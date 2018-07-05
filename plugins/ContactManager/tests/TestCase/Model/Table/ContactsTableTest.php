<?php
namespace ContactManager\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use ContactManager\Model\Table\ContactsTable;

/**
 * ContactManager\Model\Table\ContactsTable Test Case
 */
class ContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \ContactManager\Model\Table\ContactsTable
     */
    public $Contacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.contact_manager.contacts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Contacts') ? [] : ['className' => ContactsTable::class];
        $this->Contacts = TableRegistry::get('Contacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contacts);

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
}
