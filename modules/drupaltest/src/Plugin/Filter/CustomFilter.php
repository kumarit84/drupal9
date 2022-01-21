<?php

declare(strict_types=1);

namespace Drupal\drupaltest\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * @Filter(
 *   id = "custom_filter",
 *   title = @Translation("Custom Filter"),
 *   description = @Translation("Change the token hompage with homepage url"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class CustomFilter extends FilterBase {

  public function process($text, $langcode) {
    $homepage_filter_tooltip = $this->settings['homepage_filter_tooltip'] ? ' This is homepage url!' : '';
    $replace = '<span class="custom-filter"><a href="/drupaldemo" title="'.$homepage_filter_tooltip.'">' . $this->t('Homepage') . '</a></span>';
    $new_text = str_replace('[homepage]', $replace, $text);

    $result = new FilterProcessResult($new_text);

    if($this->settings['homepage_filter_css']){
         $result->setAttachments(array(
            'library' => array(
                'drupaltest/homepagefilter',
              ),
         ));
    }

    return $result;
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['homepage_filter_tooltip'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Homepage link tooltip?'),
      '#default_value' => $this->settings['homepage_filter_tooltip'],
      '#description' => $this->t('Enable this places tooltip for the homepage url.'),
    );

    $form['homepage_filter_css'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Homepage Filter library for format the link?'),
      '#default_value' => $this->settings['homepage_filter_css'],
      '#description' => $this->t('Change of hompage link format using css.'),
    );

    return $form;
  }

}
