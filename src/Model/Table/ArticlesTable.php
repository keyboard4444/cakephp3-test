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
        
        
//        $this->belongsTo('Users');
    }
    
    
    public function findMycustomfinder(Query $query, array $options)
    {
        return $query->where([
            'published' => true,
            'id >=' => 3
        ]);
    }
    
    public function findPublished(Query $query, array $options)
    {
        $query->where([
            $this->alias() . '.published' => 1
        ]);
        return $query;
    }
}