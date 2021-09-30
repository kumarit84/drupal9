<?php

declare(strict_types=1);

namespace Drupal\drupaltest\Element;

use Drupal\Core\Render\Element\RenderElement;


/**
 * Provides a processed text render element.
 *
 * @RenderElement("marquee")
 */
class Marquee extends RenderElement {


  public function getInfo() {
   
     return [
       '#theme' => 'marquee',
       '#content' => '',
       '#attributes' => [
         'width' => '100%',
         'direction' => 'right',
         'height' => '100%',
       ],
     ];
  }

}
