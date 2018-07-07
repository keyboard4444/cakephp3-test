<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsTable Test Case
 */
class ProductsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsTable
     */
    public $Products;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Products') ? [] : ['className' => ProductsTable::class];
        $this->Products = TableRegistry::get('Products', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Products);
        
        TableRegistry::clear();

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    
    public function testFindHello()
    {
        //Creating a Test Method
        //https://book.cakephp.org/3.0/en/development/testing.html#creating-a-test-method
        $query = $this->Products->find('hello')->select(['id', 'name']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->hydrate(false)->toArray();
        $expected = [
            [
                'id' => 1,
                'name' => 'HAI AWAK'
            ],
            [
                'id' => 2,
                'name' => 'KEEPER KAT MANA'
            ]
        ];
        $this->assertEquals($expected, $result);
    }
    
    public function testMocking()
    {
        //by default this is the output
        $this->assertEquals('HELLO WORLD', $this->Products->helloworld()); //output: HELLO WORLD
        $this->assertEquals('HELLO MOON', $this->Products->helloworld('MOON')); //output: HELLO MOON
        
        //Mocking Model Methods
        //https://book.cakephp.org/3.0/en/development/testing.html#mocking-model-methods
        $model = $this->getMockForModel('Products', ['helloworld']);
        
        //but you can override the function results
        $model
            ->expects($this->once())
            ->method('helloworld')
            ->will($this->returnValue('HELLO ADELLE'));
        $this->assertEquals('HELLO ADELLE', $model->helloworld()); //output: HELLO ADELLE
    }
}
