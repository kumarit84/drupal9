<?php

namespace Drupal\drupaltest\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\drupaltest\Services\DrupaltestService;
use Drupal\Core\State\State;
/**
 * Form that performs favorite animal test.
 *
 * @internal
 */
class ConfigForm extends ConfigFormBase {

  protected $drupaltestservice;

  protected $state;

  public function __construct(DrupaltestService $drupaltestservice, State $state) {
    $this->drupaltestservice = $drupaltestservice;
    $this->state = $state;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('drupaltest.getsitename'),
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupal_stateapi_form';
  }

  protected function getEditableConfigNames() {
    return ['drupaltest.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,$tid='') {
    
    $config = $this->config('drupaltest.settings');

    $form['site_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('State api Message.'),
      '#default_value' => $this->state->get('drupaltest.site_message'),
    ];

    $form['configapi_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Config api Message.'),
      '#default_value' => $config->get('config_message'),
    ];

    $form['submit_message'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit your message'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
        $this->state->set('drupaltest.site_message',$form_state->getValue('site_message'));
        $this->config('drupaltest.settings')
        // Remove unchecked types.
          ->set('config_message', $form_state->getValue('configapi_message'))
          ->save();  
  }

}
