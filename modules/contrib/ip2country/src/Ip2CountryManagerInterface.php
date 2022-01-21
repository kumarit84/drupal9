<?php

namespace Drupal\ip2country;

/**
 * Interface for Ip2CountryManager.
 */
interface Ip2CountryManagerInterface {

  /**
   * Updates the database.
   *
   * Truncates ip2country table then reloads from ftp servers. These steps
   * are performed within a transaction to ensure that no data is lost if
   * the update fails.
   *
   * @param string $registry
   *   Regional Internet Registry from which to get the data.
   *   Allowed values are afrinic, apnic, arin (default), lacnic, or ripe.
   * @param bool $md5_checksum
   *   Whether to compare the MD5 checksum downloaded from the RIR with the MD5
   *   checksum calculated locally to ensure the data has not been corrupted.
   *   Default is FALSE because RIRs don't always provide a checksum.
   * @param int $batch_size
   *   The number of rows to write to the database at one time. Increasing this
   *   value will consume more memory but will take less time and make fewer
   *   database queries. Default is 200.
   *
   * @return int|false
   *   FALSE if database update failed. Otherwise, returns the number of
   *   rows in the updated database.
   */
  public function updateDatabase($registry = 'arin', $md5_checksum = FALSE, $batch_size = 200);

  /**
   * Empties the ip2country table in the database.
   */
  public function emptyDatabase();

  /**
   * Gets the total count of IP ranges in database.
   *
   * @return int
   *   Integer count of the number of rows in the ip2country table.
   */
  public function getRowCount();

}
