<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
//use Cake\Collection\Collection;

class ArticlesController extends AppController
{
    /*
     * study cakephp collection: https://book.cakephp.org/3.0/en/core-libraries/collections.html
     */
    public function studycollection(){
        
        //in order to use collection, you need to "use Cake\Collection\Collection" first
        //Note that collection has 2 .php file, the CollectionTraits and CollectionInterface
        
        //Quick Example https://book.cakephp.org/3.0/en/core-libraries/collections.html#quick-example
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
//        $collection = new Collection($items); //if you use this, you need to "use Cake\Collection\Collection;"
        $collection = collection($items); //while for this, you dont need to "use Cake\Collection\Collection;"

        // Create a new collection containing elements
        // with a value greater than one.
        pr("============FIRST EXAMPLE");
        $overOne = $collection->filter(function ($value, $key, $iterator) {
            return $value > 1;
        });
        pr($overOne); //return Collection-Iterator-FilterIterator Object
        pr($overOne->toArray()); //can see the results here
        
        
        //Iterating https://book.cakephp.org/3.0/en/core-libraries/collections.html#iterating
        /*pr("============Iterating");
        $collection = collection($items);
        $test1 = [];
        $test1 = $collection->each(function ($value, $key) {
            return $value * 2;
        });
        pr($collection->toArray());
        pr($test1->toArray());*/
        
        //using map
        pr("============Iterating using MAP");
        $collection = collection($items);
        $test1 = [];
        $test1 = $collection->map(function ($value, $key) {
            return $value * 2;
        });
        pr($collection->toArray());
        pr($test1->toArray()); //you can see the differences between toList() and toArray() here
        pr($test1->toList());
        
        
        //TO BE CONTINUE: STUDY start from "Cake\Collection\Collection::extract"
        
        
        $this->loadModel("Contacts");
        
        //use this as base data shall we
        pr("============Sample data");
        $query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->contain(['Users']);
        //pj($query);
        
        
        $this->render(DS.'blank');
    }
    
    /**
     * study query builder tutorial at https://book.cakephp.org/3.0/en/orm/query-builder.html
     */
    public function studyquerybuilder(){
        
        $this->loadModel("Contacts");
        
        
        /*$articles = TableRegistry::get('Articles'); //need to "use Cake\ORM\TableRegistry;" to use this
        $query = $articles->find()->first();
        pj($query);*/
        
        
        //sample of using find
        /*$query = $this->Articles
            ->find()
            ->select(['id', 'user_id', 'title', 'slug'])
            ->where(['id !=' => 1])
            ->order(['created' => 'DESC'])
            ->limit(3);
        pj($query);*/
        
        //there is differences between limit(1) and first()
        /*$query = $this->Articles
            ->find()
            ->select(['id', 'user_id', 'title', 'slug'])
            ->where(['id !=' => 1])
            ->order(['created' => 'DESC'])
            ->first();
        pj($query);*/
        
        
        /**
         * comparing differences between find using
         * ... (none)   = Return ORM-Query Object
         * all()        = Return ORM-ResultSet Object   + Return Items->0->name
         * toList()     = Return Entity Object  + Return [0]->name
         * toArray()    = Return Entity Object  + Return [0]->name
         * first()      = Return Entity Object  + 
         */
        /*$query = $this->Contacts
            ->find()
            ->where(['id >=' => 1]);
        pr("==========BLANK");
//        pr($query);
//        pj($query);
        
        $query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->contain(['Users'])
            ->all();
        pr("==========ALL");
//        pr($query);
//        pj($query);
        
        $query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->contain(['Users'])
            ->toList();
        pr("==========TO LIST");
//        pr($query);
//        pj($query);
//        $query[0]->name;
//        $query[0]['name'];
        
        $query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->contain(['Users'])
            ->toArray();
        pr("==========TO ARRAY");
//        pr($query);
//        pj($query);
//        $query[0]->name;
//        $query[0]['name'];
        */
        
        
        //Selecting A Single Row From A Table VS select using LIMIT=1
        /*$query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->first();
        pr("==========Selecting A Single Row From A Table");
        pr($query);
        pj($query);
        pr($query->name);
        
        $query = $this->Contacts
            ->find()
            ->where(['Contacts.id >=' => 1])
            ->limit(1)
            ->toArray();
        pr("==========Selecting using limit and toArray");
        pr($query);
        pj($query);
        pr($query[0]->name);*/
        
        
        //Getting A List Of Values From A Column
        //https://book.cakephp.org/3.0/en/orm/query-builder.html#getting-a-list-of-values-from-a-column
        $data1 = $this->Contacts->find()->extract('name');
        pr($data1); //Return Collection-Iterator-ExtractIterator Object
        pj($data1);
        
        
        //STOP AT: https://book.cakephp.org/3.0/en/orm/query-builder.html#getting-a-list-of-values-from-a-column
        //Later continue
    }
    
    /**
     * reading the differences between cakephp2 and cakephp3 ORM here "Find returns a Query Object" https://book.cakephp.org/3.0/en/appendices/orm-migration.html
     */
    public function listall(){
        
        //TEST1
        //according to the guide, we can use method below. but its actually execute query twice
//        $data1 = $this->Articles->find('all');
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
//        $data1->where(['Articles.title LIKE' => "%WORLD%"])->order(['title' => 'DESC']); //this will re-sql again, crawl the data to search
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
//        $data1 = $this->Articles->find('all')->where(['Articles.title LIKE' => "%WORLD%"])->order(['title' => 'DESC']); //its better to use this style then
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST2
        //below to show how to execute same result with different approaches
//        $data1 = $this->Articles->find('all')->where(['Articles.title LIKE' => "%WORLD%"])->where(['Articles.title LIKE' => "%HELLO%"]);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
//        $conditions = array();
//        $conditions['AND'][0]['Articles.title LIKE'] = "%WORLD%";
//        $conditions['AND'][1]['Articles.title LIKE'] = "%HELLO%";
//        $data1 = $this->Articles->find('all')->where($conditions);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
//        $data1 = $this->Articles->find('all', array(
//            'conditions' => $conditions
//        ));
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST3
        //using formatResults
        if( TRUE){
            $data1 = $this->Articles->find()
                ->order(['title' => 'DESC'])
                ->formatResults(function (\Cake\Collection\CollectionInterface $results) {

                    //TEST3.1
                    //default way of doing things
                    return $results->extract('title');

                    //TEST3.2
                    //separate the title and slug into different key-group
                    //hard to explain, just see the results
    //                return array(
    //                    $results->extract('title'), $results->extract('slug')
    //                );

                    //TEST3.3
                    //set the result array key to use slug instead of standard array key-counter
                    //we can also use indexBy('id') which is really cool
    //                return $results->indexBy('slug');

                    //TEST3.4
                    //we can customize additional logic and decide what we want to return
                    //but this also can be done using ENTITIES (access OR _get(...))
    //                return $results->map(function ($row) {
    //                    $new_row = array();
    //                    
    //                    $new_row['title'] = $row['title'];
    //                    $new_row['slug'] = $row['slug'];
    //                    $new_row['published'] = $row['published'];
    //                    
    //                    $new_row['txt_published'] = "PUBLISHED";
    //                    if( $new_row['published']===FALSE){
    //                        $new_row['txt_published'] = "NOT YET PUBLISHED";
    //                    }
    //                    
    //                    return $new_row;
    //                });
    //                
                    //TEST3.5
                    //since we know index and extract, we can also chain their results like below
    //                return $results->indexBy('slug')->extract('title');
            });
            pr(json_encode($data1, JSON_PRETTY_PRINT));
            pr($data1->toArray());
            pr($data1->toList());
        }
        
        
        //TEST4
        //beside using pr(JSON_PRETTY_PRINT) we can also use ->toArray()
        //but JSON_PRETTY_PRINT much better
//        $data1 = $this->Articles->find('all')->toArray();
//        pr($data1);
        
        
        //TEST5
        //find first is remove, plus we got cooler way which is get
//        $data1 = $this->Articles->get(2);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST6 : https://book.cakephp.org/3.0/en/appendices/orm-migration.html#finder-method-changes
        //using Finder Method Changes aka ->find('mycustomfinder')
        //you can also make extra conditions on top of your custom finder
//        $data1 = $this->Articles->find('mycustomfinder')->where([
//            'id <=' => 10
//        ]);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        //you can also chain find() multiple times
        //eg: find('custom1')->find('custom2')
        
        
        //TEST7
        //Need to learn more from TEST6
        //Read this tutorial
        //1. https://book.cakephp.org/3.0/en/core-libraries/collections.html
        //2. https://book.cakephp.org/3.0/en/orm/table-objects.html
        //3. https://book.cakephp.org/3.0/en/orm/query-builder.html
        //4. https://book.cakephp.org/3.0/en/orm/retrieving-data-and-resultsets.html#map-reduce
        //5. https://book.cakephp.org/3.0/en/orm/retrieving-data-and-resultsets.html
        
        
        //TEST8 : https://book.cakephp.org/3.0/en/appendices/orm-migration.html#no-afterfind-event-or-virtual-fields
        //virtual field replace by ENTITIES
//        $data1 = $this->Articles->get(2);
//        pr($data1->title_slug);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //LATER CONTINUE FROM: https://book.cakephp.org/3.0/en/appendices/orm-migration.html#no-afterfind-event-or-virtual-fields
        
        
        $this->render(DS.'blank');
    }
    
    /**
     * 
     */
    public function tryprefix(){
        
    }
    
    /**
     * Manually specify which .ctp file to be render as view
     */
    public function renderview(){
        
        $this->render(DS.'blank'); //will look for file in = src/Template/blank.ctp
        //$this->render(DS.'Articles'.DS.'helloworld'); //will look for file in = src/Template/Articles/helloworld.ctp
        //$this->render('helloworld'); //will look for file in = src/Template/Articles/Articles/helloworld.ctp
        //$this->render('Articles'.DS.'helloworld'); //will look for file in = src/Template/Articles/Articles/helloworld.ctp
    }
    
    /**
     * Will explain in routerurl
     */
    public function gotmyownname(){
        $this->render(DS.'blank');
    }
    
    /**
     * Testing echo router URL
     */
    public function routerurl(){
        
        //there is different for ID with key (and without)
        pr(Router::url(['controller' => 'Articles', 'action' => 'view', 15]));
        pr(Router::url(['controller' => 'Articles', 'action' => 'view', 'id' => 15]));
        
        /**
         * example of reverse reroute
         * test1 is declared in routes.php to be just "/test1" (without articles)
         * test2 is not declared, thus "articles/test2"
         */
        pr(Router::url(['controller' => 'Articles', 'action' => 'test1']));
        pr(Router::url(['controller' => 'Articles', 'action' => 'test2']));
        
        /**
         * i defined the function name a routes with "special name"
         * , plus this also a reverse routing function
         * 
         * note that reverse reroute can be call in URL using
         * 1. /mynameis
         * 2. /articles/gotmyownname
         */
        pr(Router::url(['controller' => 'Articles', 'action' => 'gotmyownname']));
        pr(Router::url(['_name' => 'whatismyname']));
        
        $this->render(DS.'blank');
    }
    
    /**
     * in routes has define "greedyurl/*"
     * any string at the * will be converted into a function parameters where the value is set as array
     */
    public function greedyurl(...$variadic_splat){ //writing "/greedyurl/test1/test2" means $variadic_splat = array('test1', 'test2')
        
        pr($variadic_splat);
        
        $this->render(DS.'blank');
    }
    
    /**
     * double trailing start at routes "/verygreed/**"
     * 
     * "cakephp3-test/verygreed/lol" and see the result
     * then change "...$random_data" into "$random_data" to see the differences
     */
    public function doubletrailstarroute(...$random_data){
        
        pr($random_data);
        
        $this->render(DS.'blank');
    }
    
    /**
     * from fixed url, you can pass default data
     */
    public function passme( $special_data=null){
        
        pr("special_data=".$special_data);
        
        $this->render(DS.'blank');
    }
    
    /**
     * 
     */
    public function commonrouting($special_data){
        
        pr($special_data);
    }
    
    public function display()
    {
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
        
        
        
    }
    
    
    




    public function view( $ida_1=null){
//        pr($param1);
        $this->set("param1", $ida_1);
    }
    
    
    //BELOW IS ALL DUMMY FUNCTION
    public function test1(){
        $this->render(DS.'blank');
    }
    public function test2(){
        $this->render(DS.'blank');
    }
}