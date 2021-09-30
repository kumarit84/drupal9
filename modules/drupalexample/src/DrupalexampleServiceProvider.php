<?php

namespace Drupal\drupalexample;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\drupaltest\Services\DrupaltestService;
use Symfony\Component\DependencyInjection\Reference;



/**
 * Returns responses for History module routes.
 */
class DrupalexampleServiceProvider extends ServiceProviderBase {

  public function alter(ContainerBuilder $container){

     $container->getDefinition('drupaltest.drupalutility')
        ->setClass('Drupal\drupalexample\DrupalexampleUtility');
        //->addArgument(new Reference('current_user'),new Reference('drupaltest.getsitename'));
  }
}
