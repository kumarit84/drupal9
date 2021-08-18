<?php

namespace Drupal\drupaltest\EventSubscriber;

use Drupal\drupaltest\Event\CustomNodeEvent;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Returns responses for History module routes.
 */
class CustomNodeEventSubscriber implements EventSubscriberInterface {


  use StringTranslationTrait;
  
  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }


  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[CustomNodeEvent::NODEADD_EVENT][] = ['nodeSave'];
    $events[CustomNodeEvent::NODEUPDATE_EVENT][] = ['nodeUpdate'];
    return $events;
  }

    /**
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The Event to process.
   */
  public function nodeSave(CustomNodeEvent $node) {
    $nodeObj=$node->getNodeObj();
    $this->messenger->addStatus($this->t('Event is fired on node add : @node_title by @username ->>> Therikavidalama',['@node_title'=> $nodeObj->getTitle(),'@username' => $nodeObj->getOwner()->getDisplayname()]));
  }


    /**
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The Event to process.
   */
  public function nodeUpdate(CustomNodeEvent $node) {
    $nodeObj=$node->getNodeObj();
    $this->messenger->addStatus($this->t('Event is fired on node update : @node_title by @username ->>> Therikavidalama',['@node_title'=> $nodeObj->getTitle(),'@username' => $nodeObj->getOwner()->getDisplayname()]));
  }

}
