<?php

declare(strict_types=1);

namespace Drupal\drupaltest\Controller;



/**
 * Returns responses for History module routes.
 */
class CustomTag {

  public function content(){
    $build = [];

    $build['Heading'] = [
      '#plain_text' => 'Test the usage of custom Render element',
    ];

    $build['marquee'] = [
      '#type' => 'marquee',
      '#content'=>'test marquee',
      '#attributes' => [
         'width' => '50%',
         'direction' => 'left',
         'height' => '50%',
       ],
    ];

    return $build;
  }

}
