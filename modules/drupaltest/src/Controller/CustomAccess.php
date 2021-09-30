<?php

namespace Drupal\drupaltest\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\drupaltest\Services\DrupaltestService;



/**
 * Returns responses for History module routes.
 */
class CustomAccess extends ControllerBase {


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

  protected $drupaltestservice;

  public function __construct(AccountInterface $account, DrupaltestService $drupaltestservice){
    $this->account = $account;
    $this->drupaltestservice = $drupaltestservice;
  }

  public static function create(ContainerInterface $container){
    return new static(
      $container->get('current_user'),
      $container->get('drupaltest.getsitename')
    );

  }


  public function AccessOverideCheck(){
      $username = $this->account->getDisplayName();
      $message = 'Access overide Check from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }
 
  public function customAccessCheck(){
      $username = $this->account->getDisplayName();
      $message = 'CustomAccess Check from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }

  public function access(){
    return AccessResult::allowedIf($this->account->hasPermission('create article content'));
  }

}
