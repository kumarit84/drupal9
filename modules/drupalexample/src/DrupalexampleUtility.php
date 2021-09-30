<?php

namespace Drupal\drupalexample;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\drupaltest\Services\DrupaltestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns responses for History module routes.
 */
class DrupalexampleUtility extends ControllerBase {

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

  /**
   * {@inheritdoc}
   */
  public function checkColor($color=null) {
    $colorsArray = array('red','yellow','blue','black','green');
    if(in_array($color,$colorsArray)){
      return true;
    }
    return false;

  }

  public function getHomepage(){
    global $base_url;
    $username = $this->account->getDisplayName();
    $message = 'Hello world overwrite the service from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();
    $message .= '<br/>Base url : '.$base_url;
    return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];  
  }


}
