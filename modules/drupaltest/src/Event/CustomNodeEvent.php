<?php

namespace Drupal\drupaltest\Event;

use Drupal\node\NodeInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\EventDispatcher\Event;

/**
 * Defines a Locale event.
 */
class CustomNodeEvent extends Event {

  use StringTranslationTrait;

  const NODEADD_EVENT = 'node.add_details';

  const NODEUPDATE_EVENT = 'node.update_details';


  protected $node;


  public function __construct(NodeInterface $node) {
    $this->node = $node;
//    \Drupal::messenger()->addStatus($this->t('@username has posted the node: @nodetitle', ['@nodetitle' => $this->node->getTitle(),'@username' => $this->node->getOwner()->getDisplayname()]));
  }

  public function getNodeObj(){
    return $this->node;
  }

}
