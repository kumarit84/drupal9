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
      '#plain_text' => 'Test the usage of custom Render tag marquee element',
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

    $build['progress'] = [
      '#type' => 'progress',
      '#content'=>'60%',
      '#attributes' => [
        'id'=>'id_progress',
        'max'=> 100,
        'value'=> 60,
       ],
    ];

    return $build;
  }


}
