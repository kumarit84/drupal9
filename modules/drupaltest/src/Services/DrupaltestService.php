<?php

namespace Drupal\drupaltest\Services;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Returns responses for History module routes.
 */
class DrupaltestService{

  /**
   * Returns a set of nodes' last read timestamps.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request of the page.
   *
   * @return Symfony\Component\HttpFoundation\JsonResponse
   *   The JSON response.
   */
  protected $account;

  
  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory,AccountInterface $account){
    $this->configFactory = $config_factory;
    $this->account = $account;
  }

  public function getSitename(){
    $siteConfig = $this->configFactory->get('system.site')->getRawData();
    return $siteConfig['name'];
  }

  public function getAcccountEmail(){
    return $this->account->getEmail();
  }

  public function getCurrentTimestamp(){
    return time();
  }

}
