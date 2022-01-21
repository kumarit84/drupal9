<?php

namespace Drupal\drupaltest\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "simplemodal_example_block",
 *   admin_label = @Translation("Simple Modal block"),
 * )
 */
class SimpleLinkModal extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $variables['#attached']['library'][] = 'drupaltest/globaljs';
    $renderable = [
      '#theme' => 'node_modal',
      '#nid' => 2,
      '#attached' => [
        'library' => ['drupaltest/globaljs']
      ]
    ];

    return $renderable;
  }






}
