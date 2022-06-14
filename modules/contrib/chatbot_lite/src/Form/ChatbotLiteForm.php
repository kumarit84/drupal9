<?php

namespace Drupal\chatbot_lite\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\BeforeCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\chatbot_lite\Controller\ChatbotLiteAnswers;

/**
 *
 */
class ChatbotLiteForm extends FormBase
{
  protected $settings;

  /**
   * Constructs a new HelloForm object.
   */
  public function __construct()
  {
    $this->settings = \Drupal::config('chatbot_lite.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'chatbot_lite_form';
  }


  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['open'] = [
      '#markup' => '<span class="chatbot-lite-open">' . $this->t($this->settings->get('bot_cta')) . '</span>',
    ];

    $form['chatbot_lite_form'] = [
      '#type' => 'container',
      '#attributes' => [
        'hidden' => FALSE,
        'class' => ['form-control', 'chatbot-lite-window'],
      ],
    ];

    $form['chatbot_lite_form']['top'] = [
      '#markup' => '<div class="chatbot-lite-window-top">'
        . '<span class="chatbot-lite-title">' . $this->t($this->settings->get('bot_window_title')) . '</span>'
        . '<span class="chatbot-lite-close">X</span>'
        . '</div>'
    ];

    $form['chatbot_lite_form']['chatbot-lite-body'] = [
      '#type' => 'container',
      '#weight' => 0,
      '#attributes' => [
        'hidden' => false,
        'class' => ['chatbot-lite-body'],
      ],
    ];

    $form['chatbot_lite_form']['chatbot-lite-body']['welcome'] = [
      '#markup' => '<div class="bot-message bot-welcome">'
        . '<div class="bot-user">'
        . $this->t($this->settings->get('bot_name'))
        . '</div>'
        . $this->t($this->settings->get('bot_welcome_message')) . '</div>'
    ];

    $form['chatbot_lite_form']['bottom'] = [
      '#type' => 'container',
      '#weight' => 0,
      '#attributes' => [
        'hidden' => false,
        'class' => ['chatbot-lite-bottom'],
      ],
    ];

    $form['chatbot_lite_form']['bottom']['chatbot-lite-input'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t($this->settings->get('bot_input_placeholder')),
      '#attributes' => [
        'hidden' => false,
        'class' => ['chatbot-lite-input'],
      ],
    ];

    $form['chatbot_lite_form']['bottom']['chatbot-lite-button'] = [
      '#type' => 'button',
      '#value' => $this->t('Send'),
      '#ajax' => [
        'callback' => [$this, 'humanQuestionAjax'],
        'fade' => true,
        'event' => 'click',
        'method' => 'replace',
        'effect' => 'fade',
        'disable-refocus' => true,
        'progress' => [
          'type' => 'throbber',
        ],
      ],
      '#attributes' => [
        'class' => ['button', 'use-ajax']
      ],
    ];

    $form['#cache'] = ['max-age' => 0];
    $form['#actions']['#submit'] = [$this, 'humanQuestionAjax'];
    $form['#attached']['library'][] = 'chatbot_lite/chatbot_lite';

    return $form;
  }

  /**
   *
   */
  public function humanQuestionAjax(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    $domId = '#edit-chatbot-lite-body';
    $user = \Drupal::currentUser()->isAnonymous() ? $this->t("You") : \Drupal\user\Entity\User::load(\Drupal::currentUser()->id())->get('name')->value;
    $question_txt = strlen($form_state->getValue('chatbot-lite-input')) > 0 ? $form_state->getValue('chatbot-lite-input') : '...';
    $question = '<div class="bot-message bot-question">'
      . '<div class="bot-user">'
      . $user
      . '</div>'
      . $question_txt
      . '</div>';
    $answer = new ChatbotLiteAnswers();
    $answer = '<div class="bot-message bot-answer">'
      . '<div class="bot-user">'
      . $this->t($this->settings->get('bot_name'))
      . '</div>'
      . $answer->getAnswer($form_state->getValue('chatbot-lite-input'))
      . '</div>';
    $response->addCommand(new InvokeCommand('#edit-chatbot-lite-input', 'val', ['']));
    $response->addCommand(new AppendCommand($domId, $question));
    $response->addCommand(new AppendCommand($domId, $answer));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Display result.
  }
}
