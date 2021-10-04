<?php
namespace Drupal\drupalexample\Twig\Extension;


/**
 * Class TwigFunctionExtension.
 */
class TwigFunctionExtension extends \Twig_Extension {
  /**
   * Declare your custom twig extension here
   *
   * @return array|\Twig_SimpleFunction[]
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('display_block_by_id',
        array($this, 'display_block'),
        array('is_safe' => array('html'))
      )
    );
  }
  /**
   * Function to get and render block by id
   * @param $block_id
   *  Block id to render
   *
   * @return array
   */
  public function display_block($block_id) {
    $block = \Drupal\block\Entity\Block::load($block_id);
    return \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
  }
  /**
   * {@inheritdoc}
   * @return string
   */
  public function getName() {
    return 'twig_extension.function';
  }
}