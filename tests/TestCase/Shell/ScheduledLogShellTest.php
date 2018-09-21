<?php
namespace App\Test\TestCase\Shell;

use App\Shell\ScheduledLogShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\ScheduledLogShell Test Case
 */
class ScheduledLogShellTest extends ConsoleIntegrationTestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\ScheduledLogShell
     */
    public $ScheduledLog;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->ScheduledLog = new ScheduledLogShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScheduledLog);

        parent::tearDown();
    }
}
