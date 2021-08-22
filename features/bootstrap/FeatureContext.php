<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Context\RawDrupalContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements Context
{

    protected $minkContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

   /**
    * Fill in wysiwyg on field.
    *
    * @Then I fill in wysiwyg on field :locator with :value
    */
    public function iFillInWysiwygOnFieldWith($locator, $value) {
      $el = $this->getSession()->getPage()->findField($locator);
      if (empty($el)) {
        throw new ExpectationException('Could not find WYSIWYG with locator: ' . $locator, $this->getSession());
      }
      $fieldId = $el->getAttribute('id');
      if (empty($fieldId)) {
       throw new Exception('Could not find an id for field with locator: ' . $locator);
      }
      $this->getSession()
        ->executeScript("CKEDITOR.instances[\"$fieldId\"].setData(\"$value\");");
  }
}
