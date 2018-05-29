<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

use Cake\ORM\Query;

class ContactsTable extends Table
{
    public function initialize(array $config)
    {
        
        
        $this->belongsTo('Users');
    }
}