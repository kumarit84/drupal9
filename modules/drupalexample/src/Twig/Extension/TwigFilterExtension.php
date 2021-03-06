<?php
namespace Drupal\drupalexample\Twig\Extension;


/**
 * Class TwigFilterExtension.
 */
class TwigFilterExtension extends \Twig_Extension{
  /**
   * Declare your custom twig filter here
   *
   * @return array|\Twig_SimpleFilter[]
   */
  public function getFilters()
  {
    return [ 
      new \Twig_SimpleFilter(
        'remove_links', 
        array($this, 'removeLinks')
      )
    ];
  }
  /**
   * Function to remove only links from the html
   * @param $string
   *  Html as string
   *
   * @return string
   *  Filtered html
   */
  public static function removeLinks($string)
  {
    return preg_replace('#<a.*?>(.*?)</a>#i',
      '\1',
      $string);
  }
  /**
   * {@inheritdoc}
   * @return string
   */
  public function getName()
  {
    return 'twig_extension.filter';
  }
}