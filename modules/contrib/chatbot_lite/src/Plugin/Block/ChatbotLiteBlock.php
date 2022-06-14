<?php

namespace Drupal\chatbot_lite\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Chatbot Lite' block that adds a Modal Chatbot.
 *
 * @Block(
 *   id = "chatbot_lite_block",
 *   admin_label = @Translation("Chatbot Lite"),
 *   category = @Translation("Chatbot")
 * )
 */
class ChatbotLiteBlock extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    return \Drupal::formBuilder()->getForm('Drupal\chatbot_lite\Form\ChatbotLiteForm');
  }
}
