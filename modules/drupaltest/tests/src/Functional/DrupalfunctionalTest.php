<?php

namespace Drupal\Tests\drupaltest\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 **
 */
class DrupalfunctionalTest extends BrowserTestBase {

  

  protected function setUp(): void {
    parent::setUp();

  }

  protected $defaultTheme = 'stark';



  function testHomePage(){
    $this->drupalLogin($this->rootUser);
    $this->drupalGet('<front>');
    $this->assertSession()->statusCodeEquals(200);
  }

  function testReportPage(){
    $this->drupalLogin($this->rootUser);
    $this->drupalGet('/admin');
    $this->assertSession()->statusCodeEquals(200);
  }

}
