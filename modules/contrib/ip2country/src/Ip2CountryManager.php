<?php

namespace Drupal\ip2country;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Component\Utility\Environment;
use Drupal\Core\Database\Connection;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\State\StateInterface;

/**
 * The ip2country.manager service.
 */
class Ip2CountryManager implements Ip2CountryManagerInterface {

  /**
   * The database connection to use.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The logger.factory service.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $stateService;

  /**
   * The datetime.time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $timeService;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs an Ip2CountryManager object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger.factory service.
   * @param \Drupal\Core\State\StateInterface $state_service
   *   The state service.
   * @param \Drupal\Component\Datetime\TimeInterface $time_service
   *   The datetime.time service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   */
  public function __construct(Connection $connection, LoggerChannelFactoryInterface $logger_factory, StateInterface $state_service, TimeInterface $time_service, ModuleHandlerInterface $module_handler) {
    $this->connection = $connection;
    $this->loggerFactory = $logger_factory;
    $this->stateService = $state_service;
    $this->timeService = $time_service;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public function updateDatabase($registry = 'arin', $md5_checksum = FALSE, $batch_size = 200) {
    $registry = mb_strtolower(trim($registry));

    // FTP files.
    if ($registry == 'afrinic') {
      // The afrinic NIC only holds its own data, unlike every other NIC.
      $ftp_urls = [
        'ftp://ftp.ripe.net/pub/stats/afrinic/delegated-afrinic-extended-latest',
      ];
    }
    else {
      // Note, arin doesn't play by the file-naming rules.
      $ftp_urls = [
        'ftp://ftp.ripe.net/pub/stats/arin/delegated-arin-extended-latest',
        'ftp://ftp.ripe.net/pub/stats/apnic/delegated-apnic-latest',
        'ftp://ftp.ripe.net/pub/stats/lacnic/delegated-lacnic-latest',
        'ftp://ftp.ripe.net/pub/stats/afrinic/delegated-afrinic-latest',
        'ftp://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-latest',
      ];
    }

    // Set a run-time long enough so the script won't break.
    // 10 * 60 = 10 minutes!
    Environment::setTimeLimit(10 * 60);

    /*
     * Load all the new data into a temporary table so the module still works
     * while we're downloading and validating the new data.
     */

    // Ensure temporary table is missing.
    $this->connection->schema()->dropTable('ip2country_temp');

    // Obtain schema for {ip2country} table.
    $this->moduleHandler->loadInclude('ip2country', 'install');
    $specification = $this->moduleHandler->invoke('ip2country', 'schema') ?? [];
    $schema = $specification['ip2country'];

    // Create an empty table identical to the {ip2country} table.
    $this->connection->schema()->createTable('ip2country_temp', $schema);

    // Prepare a query for insertions into the temporary table.
    $query = $this->connection->insert('ip2country_temp')->fields([
      'ip_range_first',
      'ip_range_last',
      'ip_range_length',
      'country',
      'registry',
    ]);

    // Download data files from the chosen registry.
    $entries = 0;
    $summary_records = 0;
    foreach ($ftp_urls as $ftp_file) {
      // Replace Registry source with chosen registry.
      $ftp_file = str_replace('ftp.ripe', 'ftp.' . $registry, $ftp_file);

      // RipeNCC is named ripe-ncc on APNIC registry.
      if ($registry == 'apnic') {
        $ftp_file = str_replace('stats/ripencc/', 'stats/ripe-ncc/', $ftp_file);
      }

      // File delegated-ripencc-latest is named
      // delegated-ripencc-extended-latest on LACNIC registry.
      if ($registry == 'lacnic') {
        $ftp_file = str_replace('delegated-ripencc', 'delegated-ripencc-extended', $ftp_file);
      }

      // Fetch the FTP file using cURL.
      $txt = $this->fetchPage($ftp_file);
      if ($txt == FALSE) {
        // Fetch failed.
        $this->loggerFactory->get('ip2country')->warning('File empty or not found on @registry server: @ftp_file', [
          '@registry' => mb_strtoupper($registry),
          '@ftp_file' => $ftp_file,
        ]);
        return FALSE;
      }

      if ($md5_checksum) {
        // Fetch the MD5 checksum using cURL.
        $md5 = $this->fetchPage($ftp_file . '.md5');
        if ($md5 == FALSE) {
          // Fetch failed.
          $this->loggerFactory->get('ip2country')->warning('File not found on @registry server: @ftp_file.md5', [
            '@registry' => mb_strtoupper($registry),
            '@ftp_file' => $ftp_file,
          ]);
          return FALSE;
        }

        // Verify MD5 checksum.
        $temp = explode(" ", $md5);
        // ARIN returns two fields, MD5 is in first field.
        // All other RIR return four fields, MD5 is in fourth field.
        $md5 = isset($temp[3]) ? trim($temp[3]) : trim($temp[0]);

        // Compare checksums.
        if ($md5 != md5($txt)) {
          // Checksums don't agree, so drop temporary table,
          // add watchdog entry, then return error.
          $this->connection->schema()->dropTable('ip2country_temp');
          $this->loggerFactory->get('ip2country')->warning('Validation of database from @registry server FAILED. MD5 checksum provided for the @ftp_file registry database does not match the calculated checksum.', [
            '@registry' => mb_strtoupper($registry),
            '@ftp_file' => $ftp_file,
          ]);
          return FALSE;
        }
      }

      // Break the FTP file into records.
      $lines = explode("\n", $txt);
      // Free up memory.
      unset($txt);

      // Loop over records.
      $summary_not_found = TRUE;
      foreach ($lines as $line) {
        // Trim each line for security.
        $line = trim($line);

        // Skip comment lines and blank lines.
        if (substr($line, 0, 1) == '#' || $line == '') {
          continue;
        }

        // Split record into parts.
        $parts = explode('|', $line);

        // We're only interested in the ipv4 records.
        if ($parts[2] != 'ipv4') {
          continue;
        }

        // Save number of ipv4 records from summary line.
        if ($summary_not_found && $parts[5] == 'summary') {
          $summary_not_found = FALSE;
          $summary_records += $parts[4];
          continue;
        }

        // The registry that owns the range.
        $owner_registry = $parts[0];

        // The country code for the range.
        $country_code = $parts[1];

        // Prepare the IP data for insert.
        $ip_start     = (int) ip2long($parts[3]);
        $ip_end       = (int) ip2long($parts[3]) + (int) $parts[4] - 1;
        $range_length = (int) $parts[4];

        // Insert range into the prepared query.
        $query->values([
          'ip_range_first'  => min($ip_start, $ip_end),
          'ip_range_last'   => max($ip_start, $ip_end),
          'ip_range_length' => $range_length,
          'country'         => $country_code,
          'registry'        => $owner_registry,
        ]);

        // If we have prepared enough rows (= batch size) to be inserted,
        // insert these rows simultaneously into temporary table.
        if ($entries > 0 && $entries % $batch_size == 0) {
          $query->execute();
        }

        // Keep track of where we are.
        $entries++;
      }

      // Insert remaining rows (< batch size) into temporary table.
      $query->execute();
      // Free up memory.
      unset($lines);
    }

    // Validate temporary table.
    // Check row count matches number of rows reported in the summary record.
    if ($summary_records == $entries) {
      // Start transaction.
      $txn = $this->connection->startTransaction();
      try {
        // Must do this in a transaction so that both functions succeed.
        // Because if one works but the other doesn't we're in trouble.
        $this->connection->schema()->dropTable('ip2country');
        $this->connection->schema()->renameTable('ip2country_temp', 'ip2country');
      }
      catch (\Exception $e) {
        // Something failed, so roll back transaction and delete temporary
        // table. The {ip2country} table will remain unchanged by this update
        // attempt.
        $txn->rollBack();
        $this->connection->schema()->dropTable('ip2country_temp');
        $this->loggerFactory->get('ip2country')->info('Exception in transaction while swapping in new DB table.', [
          'exception',
          $e,
        ]);
        return FALSE;
      }
      // Commit transaction.
      unset($txn);

      // Record the time of update.
      $this->stateService->set('ip2country_last_update', $this->timeService->getRequestTime());
      $this->stateService->set('ip2country_last_update_rir', $registry);

      // Return count of records in the table.
      return $entries;
    }
    else {
      // Validation failed, so drop temporary table, add watchdog entry,
      // then return error.
      $this->connection->schema()->dropTable('ip2country_temp');
      $this->loggerFactory->get('ip2country')->warning('Validation of database from @registry server FAILED. Server summary reported @summary rows available, but @entries rows were entered into the database.', [
        '@registry' => mb_strtoupper($registry),
        '@summary' => $summary_records,
        '@entries' => $entries,
      ]);
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function emptyDatabase() {
    $this->connection->truncate('ip2country')->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function getRowCount() {
    $count = $this->connection->select('ip2country')
      ->countQuery()
      ->execute()
      ->fetchField();
    return (int) $count;
  }

  /**
   * Utility function which fetches pages via FTP using cURL.
   *
   * @param string $url
   *   The ftp URL where the file is located.
   *
   * @return string|false
   *   FALSE if ftp fetch failed. Otherwise, a string containing the contents
   *   of the fetched file.
   */
  protected function fetchPage($url) {
    $curl = curl_init();

    // Fetch requested file.
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60 * 2);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Drupal (+http://drupal.org/)');
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

    $html = curl_exec($curl);
    curl_close($curl);

    return $html;
  }

}
