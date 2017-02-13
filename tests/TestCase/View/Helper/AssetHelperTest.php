<?php
namespace Asset\Test\TestCase\View\Helper;

use Asset\View\Helper\AssetHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Asset\View\Helper\AssetHelper Test Case
 */
class AssetHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Asset\View\Helper\AssetHelper
     */
    public $Asset;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Asset = new AssetHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Asset);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
