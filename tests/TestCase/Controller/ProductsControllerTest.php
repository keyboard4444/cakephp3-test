<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ProductsController;
use Cake\TestSuite\IntegrationTestCase;
use App\Lib\Apicaller;

/**
 * App\Controller\ProductsController Test Case
 */
class ProductsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/products');

        $this->assertResponseOk();
        $this->assertResponseContains('HAI AWAK');
        $this->assertResponseContains('KEEPER KAT MANA');
    }
    
    /*
     * inside product/goodmorning will return 'HOW ARE YOU'
     * but we want to override them into 'IM FINE TQ' using mock
     */
    public function testUsemock()
    {
        $this->get('/products/goodmorning');
        $this->assertResponseOk();
        $this->assertResponseContains('HOW ARE YOU');
        
        //try to overwrite a but fail
//        $stub = $this->getMockBuilder('Apicaller')->setMethods(['testing_api'])->getMock();
//        $stub->method('testing_api')->will($this->returnValue('IM FINE TQ'));
//        pr($stub->testing_api());
        
//        $asd = $this->getMockClass('App\Lib\Apicaller', ['testing_api']);
//        $asd->method('testing_api')->will($this->returnValue('IM FINE TQA'));
//        pr($asd->testing_api());
//        
////        App\Lib\Apicaller
//        $asd = new Apicaller();
//        $asd->testing_api();
//        
//        $this->get('/products/goodmorning');
//        $this->assertResponseOk();
//        $this->assertResponseContains('HOW ARE YOU');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
