<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

use Cake\ORM\Query;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
    
    
    public function findMycustomfinder(Query $query, array $options)
    {
        return $query->where([
            'published' => true,
            'id >=' => 3
        ]);
    }
}