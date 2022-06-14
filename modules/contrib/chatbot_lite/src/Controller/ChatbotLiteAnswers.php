<?php

namespace Drupal\chatbot_lite\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Chatbot Lite Answers class.
 *
 * @ChatbotLiteAnswers
 * Defines ChatbotLiteAnswers Controller class.
 */
class ChatbotLiteAnswers extends ControllerBase
{
  protected $settings;
  protected $question;
  protected $answer;
  protected $question_words;

  /**
   * Constructs a new object.
   */
  public function __construct()
  {
    $this->settings = \Drupal::config('chatbot_lite.settings');
  }

  public function getAnswer($question)
  {
    try {
      $this->setQuestion($question);
      $this->getValidQuestion();
      $this->getSearchableEntities();
      $this->getNothingFound();
    } catch (\Exception $e) {
      $this->getNothingFound();
    }

    return $this->answer;
  }

  protected function setQuestion(&$question)
  {
    $words = explode(PHP_EOL, $this->normalize($question));
    $question = implode(' ', $words);
    $words = explode(' ', $question);
    $this->question_words = array_filter(array_filter($words, [$this, 'cleanQuestion']));
  }

  /**
   * Searchs for a valid answer on setting bot_questions
   */
  protected function getValidQuestion()
  {
    if ($this->answer) {
      return;
    }
    $question_and_answers = explode(PHP_EOL, $this->settings->get('bot_answer_questions'));
    $answers = [];
    foreach ($question_and_answers as $value) {
      $qa = explode('|', $value);
      if (count($qa) === 2 && in_array($this->normalize($qa[0]), $this->question_words)) {
        $answers[] = $qa[1];
      }
    }
    if (empty($answers)) {
      return;
    }
    shuffle($answers);
    $this->answer = $answers[0];
  }

  /**
   * Searchs for a valid answer on the entities chosen at setting bot_searchable_entities
   */
  protected function getSearchableEntities()
  {
    if ($this->answer) {
      return;
    }
    $entities = array_filter(array_values($this->settings->get('bot_searchable_entities')));
    if (empty($entities)) {
      return;
    }
    // Entity queries by default consider the node grants system, so no need to check access
    $query = \Drupal::entityQuery('node');
    $query->condition('type', $entities, 'IN');
    $orGroup = $query->orConditionGroup();
    for ($i = 0; $i < count($this->question_words); $i++) {
      $orGroup->condition('title', $this->question_words[$i], 'CONTAINS');
    }
    $query->condition($orGroup);
    $query->range(0, 5);
    $node_ids = $query->execute();

    if (!$node_ids) {
      return;
    }

    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($node_ids);
    $answers = explode(PHP_EOL, $this->settings->get('bot_answer_titles'));
    shuffle($answers);
    $this->answer = $answers[0] . '<BR/>';

    foreach ($nodes as $node) {
      $url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $node->id()]);
      $this->answer .= '<a href="' . $url->toString() . '" class="ui-button">' . $node->label() . '</a>';
    }
  }

  /**
   * Searchs for a valid answer on setting bot_answer_nothing_found
   */
  protected function getNothingFound()
  {
    if ($this->answer) {
      return;
    }
    $answers = explode(PHP_EOL, $this->settings->get('bot_answer_nothing_found'));
    shuffle($answers);
    $this->answer = $answers[0];
  }

  /**
   * Auxiliar method to filter words to be ignored
   *
   * @param $word
   *   The string to be evaluated
   *
   * @return boolean
   *   True if the word don't exist in setting bot_answer_words_to_ignore
   */
  private function cleanQuestion($word)
  {
    $words_to_ignore = explode(' ', $this->normalize($this->settings->get('bot_answer_words_to_ignore')));
    return !in_array($word, $words_to_ignore);
  }

  /**
   * Strips ALL non-standard ascii characters and converts the string to lowercase for non-case comparison
   */
  private function normalize($string)
  {
    $table = array(
      'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
      'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
      'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
      'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
      'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
      'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
      'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
      'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
    );

    return strtolower(strtr($string, $table));
  }
}
