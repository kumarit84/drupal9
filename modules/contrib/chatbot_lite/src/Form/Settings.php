<?php

namespace Drupal\chatbot_lite\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure the Chatbot settings.
 */
class Settings extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'chatbot_lite_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return ['chatbot_lite.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $no_js_use = false)
  {
    $config = $this->config('chatbot_lite.settings');

    $form['chatbot_lite_fieldset'] = [
      '#type' => 'details',
      '#title' => $this->t('Settings'),
      '#open' => TRUE
    ];

    $form['chatbot_lite_fieldset']['bot_cta'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Call to Action'),
      '#description' => $this->t('The call to action label of the Bot. ex. <em>Hi, can I help?</em>'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_cta')) ?: 'Hi, can I help?',
      '#required' => TRUE,
    ];

    $form['chatbot_lite_fieldset']['bot_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('The name of the Bot. ex. <em>Chatbot Lite</em>'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_name')) ?: 'Chatbot Lite',
      '#required' => TRUE,
    ];

    $form['chatbot_lite_fieldset']['bot_window_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Window title'),
      '#description' => $this->t('The title for the Bot Window. ex. <em>Chatbot Lite</em>'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_window_title')) ?: 'Chatbot Lite',
      '#required' => TRUE,
    ];

    $form['chatbot_lite_fieldset']['bot_welcome_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Welcome Message'),
      '#description' => $this->t('Startup message is when the form loads, what would you like the first support message to be. ex. <em>Hello, I\'m here to help you.</em>'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_welcome_message')) ?: 'Hello, I\'m here to help you.',
      '#required' => TRUE,
    ];

    $form['chatbot_lite_fieldset']['bot_input_placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Input placeholder'),
      '#description' => $this->t('The placeholder inside the input. ex. <em>Ask your question</em>'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_input_placeholder')) ?: 'Ask your question',
      '#required' => TRUE,
    ];

    $all_entity_types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();
    foreach ($all_entity_types as $entity_type_id => $entity_type_obj) {
      $entity_types[$entity_type_id] = $entity_type_obj->label();
    }

    $form['entities'] = [
      '#title' => $this->t('Searchable Content Types'),
      '#type' => 'details',
      '#collapsible' => true,
      '#collapsed' => true,
    ];

    $form['entities']['bot_answer_titles'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message to place before results from content search.'),
      '#default_value' => $config->get('bot_answer_titles') ?: "Can this can help?\nIs this what you are searching for?",
      '#description' => $this->t('Place one message per line.'),
      '#required' => TRUE,
    ];

    $form['entities']['bot_searchable_entities'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content types'),
      '#options' => $entity_types,
      '#default_value' => $config->get('bot_searchable_entities'),
      '#required' => FALSE,
    ];

    $form['answer'] = [
      '#title' => $this->t('Answer Configuration'),
      '#type' => 'details'
    ];

    $form['answer']['bot_answer_questions'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Questions and Answers'),
      '#description' => $this->t('Place one question per line. Question and respective answer should be seperated by a <strong>|</strong>. ex. <em>Why|Because.</em><BR/>Questions should be one or two words maximum to have a quicker answer.'),
      '#attributes' => ['hidden' => false],
      '#default_value' => ($config->get('bot_answer_questions')) ?: 'Why|Because',
      '#required' => TRUE,
    ];

    $form['answer']['bot_answer_nothing_found'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Answers when nothing is found'),
      '#default_value' => $config->get('bot_answer_nothing_found') ?: "I'm just a robot! Can you keep it simple for me?\nI didn't understand. Can you rephrase it?",
      '#description' => $this->t('Place one answer per line.'),
      '#required' => TRUE,
    ];

    $form['answer']['bot_answer_words_to_ignore'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Words to be ignored when processing user question.'),
      '#default_value' => $config->get('bot_answer_words_to_ignore') ?: "the on if that is a at are for about looking what but you not this i'm am i am iam ",
      '#description' => $this->t('Place as many words as you need seperated by a space'),
      '#required' => TRUE,
    ];

    $form_state->setRebuild(true);
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->configFactory->getEditable('chatbot_lite.settings')
      ->set('bot_cta', $form_state->getValue('bot_cta'))
      ->set('bot_name', $form_state->getValue('bot_name'))
      ->set('bot_window_title', $form_state->getValue('bot_window_title'))
      ->set('bot_welcome_message', $form_state->getValue('bot_welcome_message'))
      ->set('bot_window_title', $form_state->getValue('bot_window_title'))
      ->set('bot_input_placeholder', $form_state->getValue('bot_input_placeholder'))
      ->set('bot_searchable_entities', $form_state->getValue('bot_searchable_entities'))
      ->set('bot_answer_questions', $form_state->getValue('bot_answer_questions'))
      ->set('bot_answer_nothing_found', $form_state->getValue('bot_answer_nothing_found'))
      ->set('bot_answer_titles', $form_state->getValue('bot_answer_titles'))
      ->set('bot_answer_words_to_ignore', $form_state->getValue('bot_answer_words_to_ignore'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}
