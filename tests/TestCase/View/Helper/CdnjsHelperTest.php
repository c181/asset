<?php
namespace Asset\Test\TestCase\View\Helper;

use Asset\View\Helper\CdnjsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Asset\View\Helper\CdnjsHelper Test Case
 */
class CdnjsHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Asset\View\Helper\CdnjsHelper
     */
    public $Cdnjs;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Cdnjs = new CdnjsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cdnjs);

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
