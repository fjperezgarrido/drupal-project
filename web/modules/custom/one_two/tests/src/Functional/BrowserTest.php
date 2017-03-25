<?php

namespace Drupal\Tests\one_two\Functional;

use Drupal\Tests\BrowserTestBase;

/**
* Example functional test.
*
* @group one_two
*/
class BrowserTest extends BrowserTestBase {

  protected $user;

  public static $modules = ['block', 'node', 'datetime'];

  protected function setUp() {
    parent::setUp();
    $this->drupalCreateContentType(['type' => 'page', 'name' => 'Basic page']);
    $this->user = $this->drupalCreateUser(['edit own page content', 'create page content' ]);
    $this->drupalPlaceBlock('local_tasks_block');
  }

  function testNodeCreate() {
    $this->drupalLogin($this->user);
    $title = $this->randomString();
    $body = $this->randomString(32);
    $edit = [
      'Title' => $title,
      'Body' => $body,
    ];
    $this->drupalPostForm('node/add/page', $edit, t('Save'));

    $node = $this->drupalGetNodeByTitle($title);
    $this->assertTrue($node);
    $this->assertEquals($title, $node->getTitle());
    $this->assertEquals($body, $node->body->value);
  }
}
