<?php

namespace Drupal\drupaltest\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "my_customblock_example_block",
 *   admin_label = @Translation("My Custom block"),
 * )
 */
class CustomBlock extends BlockBase implements TrustedCallbackInterface {


  /**
   * {@inheritdoc}
   */
  public function build() {

    $message  = 'This is the timestamp '.time();

    return [
      '#markup' => $this->t($message),
      '#cache' => [
            //'max-age' => 0,
            //'tags' => ['node_list',],
            //'tags' => ['user:2',],
            'tags' => ['node:2',],
            //'context' => ['user',],
          ]
    ];

    /*$content = [];
    $content['test'] = [
      '#lazy_builder' => [static::class . '::lazyBuildTestTable', []],
      '#create_placeholder' => TRUE,
    ];
    $content['#markup'] = $this->t('Welcome!! ');
    return $content;*/
  }



  public static function lazyBuildTestTable() {
    //sleep(3);
    return array(
      '#markup' => date('d-m-Y h:i:s')
    );
  }

      /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks() {
    return ['lazyBuildTestTable'];
  }

  /**
   * @return int
   */
 /* public function getCacheMaxAge() {
    return 0;
  }*/




}
