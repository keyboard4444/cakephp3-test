<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Article extends Entity
{
    protected $_accessible = [
//        '*' => true,
//        'id' => false,
//        'slug' => false,
        
        '*' => true,
        'title_slug' => true,
        'abangkacak' => true
    ];
    
    
    protected function _getTitleSlug()
    {
        return $this->title.' ('.$this->slug.')';
    }
}