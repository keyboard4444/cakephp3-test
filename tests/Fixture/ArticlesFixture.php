<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ArticlesFixture extends TestFixture {

    // Optional. Set this property to load fixtures to a different test datasource
    public $connection = 'test';
    
    //define table database
    /*public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false],
        'body' => 'text',
        'published' => ['type' => 'integer', 'default' => '0', 'null' => false],
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];*/
    
    //alternatively we can define the table fields by importing it from database
    //public $import = ['table' => 'articles']; //this will find table 'articles' literally in database
    public $import = ['model' => 'Articles']; //this will find 'Articles' literally in model

    //this style has weakness which is you cannot set the created date using date('Y-m-d')
    /* public $records = [
      [
      'title' => 'First Article',
      'body' => 'First Article Body',
      'published' => '1',
      'created' => '2007-03-18 10:39:23',
      'modified' => '2007-03-18 10:41:31'
      ]
      ]; */

    //so we use init(...)
    public function init() {
        $this->records = [
            [
                'title' => 'First Article',
                'body' => 'First Article Body',
                'published' => '1',
                'created' => '2007-03-18 10:39:23',
                'modified' => '2007-03-18 10:41:31',
                'user_id' => 1,
                'slug' => 'first-article',
            ],
            [
                'title' => 'Second Article',
                'body' => 'Second Article Body',
                'published' => '0',
                'created' => '2007-03-18 10:41:23',
                'modified' => '2007-03-18 10:43:31',
                'user_id' => 2,
                'slug' => 'seconds-article',
            ],
            [
                'title' => 'Third Article',
                'body' => 'Third Article Body',
                'published' => '1',
                'created' => '2007-03-18 10:43:23',
                'modified' => '2007-03-18 10:45:31',
                'user_id' => 1,
                'slug' => 'third-article',
            ]
        ];
        parent::init();
    }

}
