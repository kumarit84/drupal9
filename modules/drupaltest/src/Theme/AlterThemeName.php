<?php

namespace Drupal\drupaltest\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;

/**
 * Returns responses for module routes.
 */
class AlterThemeName implements ThemeNegotiatorInterface {
  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    return ($route_match->getRouteName() == 'drupaltest.alterthemecheck' || $route_match->getRouteName() == 'drupaltest.accessdenied');
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    if($route_match->getRouteName() == 'drupaltest.alterthemecheck'){
     return 'claro';
    }

    if($route_match->getRouteName() == 'drupaltest.accessdenied'){
     return 'seven';
    }
  }
}
