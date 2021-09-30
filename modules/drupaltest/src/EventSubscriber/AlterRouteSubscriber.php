<?php

namespace Drupal\drupaltest\EventSubscriber;


use Drupal\Core\Routing\RouteSubscriberBase;
use \Symfony\Component\Routing\RouteCollection;

/**
 * Returns responses for History module routes.
 */
class AlterRouteSubscriber extends RouteSubscriberBase{

  public function alterRoutes(RouteCollection $collection) {


    $route = $collection
     ->get('drupaltest.alterrouteexample');
    if ($route) {
      $route->setPath('/drupaltest/newalterroute');      
    }

    if($route = $collection->get('drupaltest.accessdenied')){
      $route->setRequirements(['_access'=>'TRUE',]);
    }
  }
}
