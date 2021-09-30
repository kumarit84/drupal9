<?php

namespace Drupal\Tests\Drupaltest\Unit;

use Drupal\drupaltest\DrupalUtility;
use Drupal\Tests\UnitTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 **
 */
class DrupalunitTest extends UnitTestCase {
   
  protected $account;

  protected $drupaltestservice;

  protected $drupalutility;
  

  protected function setUp(): void {
    parent::setUp();

    $this->account = $this->createMock('Drupal\Core\Session\AccountInterface');
    $this->drupaltestservice = $this->createMock('Drupal\drupaltest\Services\DrupaltestService');
    $this->drupalutility = new DrupalUtility($this->account, $this->drupaltestservice);
  }


  function testColor(){
    $color = 'red';
    $this->assertEquals(true,$this->drupalutility->checkColor($color));
  }


}
