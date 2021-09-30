<?php

namespace Drupal\drupaltest\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\drupaltest\Services\DrupaltestService;

/**
 * Provides a block with service injection.
 *
 * @Block(
 *   id = "customhook_customblock_example_block",
 *   admin_label = @Translation("Custom Hooks block"),
 * )
 */
class CustomHook extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var AccountInterface $account
   */
  protected $drupaltestservice;

  /**
   * @var AccountInterface $account
   */
  protected $account;


  /**
   * @var AccountInterface $account
   */
  protected $moduleHandler;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Session\DrupaltestService $account
   */
  
 public function __construct(array $configuration, $plugin_id, $plugin_definition, DrupaltestService $drupaltestservice, AccountInterface $account, ModuleHandlerInterface $module_handler){
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->drupaltestservice = $drupaltestservice;
    $this->account = $account;
    $this->moduleHandler = $module_handler;
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
      $container->get('module_handler'),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function build() {

     $query = \Drupal::entityQuery('node');
        $query->condition('status', 1);
        $query->condition('type', 'article')
        ->range(0,4);

    $list = $query->execute();
  
    $this->moduleHandler->invokeAll('drupaltest_node_list',[$list]);

    $liststring = implode(",",$list);

    $message  = '<marquee>Name :'.$this->account->getDisplayName().'<br/> Email id :  '.$this->drupaltestservice->getAcccountEmail().'<br/> Node list :'.$liststring.'</marquee>';


    return [
      '#markup' => $this->t($message),
      '#allowed_tags' => ['marquee'],
    ];
  }

  /**
   * @return int
   */
 /* public function getCacheMaxAge() {
    return 0;
  }*/

}
