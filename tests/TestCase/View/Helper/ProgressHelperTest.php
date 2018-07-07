<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ProgressHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class ProgressHelperTest extends TestCase
{
    public $autoFixtures = false;
    
    public $fixtures = [
        'app.articles', //will take from \tests\Fixture\ArticlesFixture.php
    ];
    
    public function setUp()
    {
        parent::setUp();
        $View = new View();
        $this->Progress = new ProgressHelper($View);
    }
    
    public function testLoadFixtureOntheFly()
    {
        $this->loadFixtures('Articles');
        $this->markTestSkipped('Test skippado.');
    }
    
    public function testHello()
    {
        //this test will fail
        //$this->assertContains('HELLO', 'HI');
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testBar()
    {
        $result = $this->Progress->bar(90);
        $this->assertContains('width: 90%', $result);
        $this->assertContains('progress-bar', $result);

        $result = $this->Progress->bar(33.3333333);
        $this->assertContains('width: 33%', $result);
    }
}
