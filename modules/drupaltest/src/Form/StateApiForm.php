<?php

namespace Drupal\drupaltest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\drupaltest\Services\DrupaltestService;
use Drupal\Core\State\State;
/**
 * Form that performs favorite animal test.
 *
 * @internal
 */
class DrupaltestForm extends FormBase {

  protected $drupaltestservice;

  protected $state

  public function __construct(DrupaltestService $drupaltestservice,State $state) {
    $this->drupaltestservice = $drupaltestservice;
    $this->state = $state;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('drupaltest.getsitename')
      $container->get('state')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupal_stateapi_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,$tid='') {
    
    $form['site_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site specific Message.'),
      '#default_value' => $this->state->get('site_message'),
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
    $sitename = $this->drupaltestservice->getSitename();

  }

}