<?php

namespace Drupal\drupaltest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\drupaltest\Services\DrupaltestService;

/**
 * Form that performs favorite animal test.
 *
 * @internal
 */
class DrupaltestForm extends FormBase {

  protected $account;

  protected $messenger;

  protected $drupaltestservice;


  public function __construct(AccountInterface $account, MessengerInterface $messenger, DrupaltestService $drupaltestservice) {
    $this->account = $account;
    $this->messenger = $messenger;
    $this->drupaltestservice = $drupaltestservice;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
      $container->get('messenger'),
      $container->get('drupaltest.getsitename')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupal_test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,$tid='') {
    
    $form['your_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your Message.'),
      '#default_value' => $tid,
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
    $username = $this->account->getDisplayName();
    $this->messenger->addStatus($this->t('@username message for the site @sitename is: @your_message', ['@your_message' => $form['your_message']['#value'],'@username' => $username,'@sitename' => $this->drupaltestservice->getSitename()]));
  }

}
