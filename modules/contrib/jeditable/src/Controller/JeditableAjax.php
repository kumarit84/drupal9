<?php

namespace Drupal\jeditable\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JeditableAjax.
 *
 * @package Drupal\jeditable\Controller
 */
class JeditableAjax extends ControllerBase {

  /**
   * Saves latest changed value.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Return Updated value.
   */
  public function jeditableAjaxSave(Request $request) {
    $id = $request->request->get('id');
    $array = explode('-', $id);

    list($entity_type, $id, $field_name, $view_mode, $delta) = $array;
    $value = $request->request->get('value');
    $storage = $this->entityTypeManager()->getStorage($entity_type);
    if ($storage instanceof EntityStorageInterface) {
      $entity = $storage->load($id);
      if ($entity instanceof FieldableEntityInterface) {
        //Check to make sure we're allowed to actually edit this field
        $entity_display = EntityViewDisplay::collectRenderDisplay($entity, $view_mode);
        $field_display = $entity_display->getComponent($field_name);
        $third_party_settings = $field_display['third_party_settings'];
        if (isset($third_party_settings['jeditable'])
          && isset($third_party_settings['jeditable']['enable_jeditable'])
          && $third_party_settings['jeditable']['enable_jeditable'] == 1) {
          $values = $entity->get($field_name)->getValue();
          if ($delta > sizeof($values)) {
            return new Response("Adding new elements is not allowed.", 403);
          }
          $values[$delta] = $value;
          $entity->set($field_name, $values);
          $entity->save();
          return new Response($value);
        } else {
          return new Response("Access Denied", 403);
        }
      }
    }
    // The entity could not be loaded, return the appropriate code.
    return new Response("Invalid Request", 400);
  }

}
