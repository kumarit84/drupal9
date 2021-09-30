<?php

declare(strict_types=1);

namespace Drupal\drupaltest\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a processed text render element.
 *
 * @RenderElement("progress")
 */
class Progress extends RenderElement {


  public function getInfo() {
   
     return [
       '#theme' => 'progress',
       '#content' => '',
       '#attributes' => [
         'id' => '',
         'max' => '1',
         'value' => '0.1',
       ],
     ];
  }

}
