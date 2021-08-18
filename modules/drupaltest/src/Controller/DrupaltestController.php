<?php

namespace Drupal\drupaltest\Controller;

use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\drupaltest\Services\DrupaltestService;


/**
 * Returns responses for History module routes.
 */
class DrupaltestController extends ControllerBase {

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

  public function getPageDisplay(Request $request) {
      //dpm($this->account);
      $username = $this->account->getDisplayName();
      $message = 'Hello world from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }

  public function getRedirectPage(Request $request) {
    return new RedirectResponse(Url::fromRoute('<front>')->setAbsolute()->toString());

  }

  public function getAlterRoutePage(Request $request) {
      //dpm($this->account);
      $username = $this->account->getDisplayName();
      $message = 'Routing change example from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }

  public function getAccessDenied(Request $request) {
      //dpm($this->account);
      $username = $this->account->getDisplayName();
      $message = 'Alter the permission of path from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }

  public function getAlterThemeCheck(Request $request) {
      //dpm($this->account);
      $username = $this->account->getDisplayName();
      $message = 'Alter the theme for path from '.$username.'<br/>-- '.$this->drupaltestservice->getAcccountEmail();

      return [
            '#type' => 'markup',
            '#markup' => $this->t($message),
          ];
  }
}
