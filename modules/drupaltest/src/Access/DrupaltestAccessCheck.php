<?php

namespace Drupal\drupaltest\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Returns responses for History module routes.
 */
class DrupaltestAccessCheck implements AccessInterface{

  public function access(AccountInterface $account) {
   return $account->hasPermission('create article content')?AccessResult::allowed():AccessResult::forbidden();
  }
}
