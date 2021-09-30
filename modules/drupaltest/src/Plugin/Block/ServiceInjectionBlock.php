<?php

namespace Drupal\drupaltest\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\drupaltest\Services\DrupaltestService;

/**
 * Provides a block with service injection.
 *
 * @Block(
 *   id = "my_serviceinjection_customblock_example_block",
 *   admin_label = @Translation("My Service Injection block"),
 * )
 */
class ServiceInjectionBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var AccountInterface $account
   */
  protected $drupaltestservice;

  /**
   * @var AccountInterface $account
   */
  protected $account;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Session\DrupaltestService $account
   */
  
 public function __construct(array $configuration, $plugin_id, $plugin_definition, DrupaltestService $drupaltestservice, AccountInterface $account){
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->drupaltestservice = $drupaltestservice;
    $this->account = $account;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('drupaltest.getsitename'),
      $container->get('current_user'),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function build() {

    $message  = 'Username : '.$this->account->getDisplayName().'<br/> Email id :  '.$this->drupaltestservice->getAcccountEmail();

    return [
      '#markup' => $this->t($message),
      '#cache' => [
            //'max-age' => 0,
            //'tags' => ['node_list',],
            //'tags' => ['user:2',],
            //'tags' => ['node:2',],
            'context' => ['user',],
          ]
    ];
  }

  /**
   * @return int
   */
 /* public function getCacheMaxAge() {
    return 0;
  }*/

}
