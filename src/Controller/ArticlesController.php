<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Routing\Router;


class ArticlesController extends AppController
{
    
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
//        $data1 = $this->Articles->find()
//            ->order(['title' => 'DESC'])
//            ->formatResults(function (\Cake\Collection\CollectionInterface $results) {
                
                //TEST3.1
                //default way of doing things
//                return $results->extract('title');
                
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
//        });
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST4
        //beside using pr(JSON_PRETTY_PRINT) we can also use ->toArray()
        //but JSON_PRETTY_PRINT much better
//        $data1 = $this->Articles->find('all')->toArray();
//        pr($data1);
        
        
        //TEST5
        //find first is remove, plus we got cooler way which is get
        $data1 = $this->Articles->get(2);
        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST6
        //using Finder Method Changes aka ->find('mycustomfinder')
        //you can also make extra conditions on top of your custom finder
//        $data1 = $this->Articles->find('mycustomfinder')->where([
//            'id <=' => 10
//        ]);
//        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        //TEST7
        //Need to learn more from TEST6
        //Read this tutorial
        //1. https://book.cakephp.org/3.0/en/core-libraries/collections.html
        //2. https://book.cakephp.org/3.0/en/orm/table-objects.html
        //3. https://book.cakephp.org/3.0/en/orm/query-builder.html
        //4. https://book.cakephp.org/3.0/en/orm/retrieving-data-and-resultsets.html#map-reduce
        //5. https://book.cakephp.org/3.0/en/orm/retrieving-data-and-resultsets.html
        
        
        //TEST8
        //virtual field replace by ENTITIES
        $data1 = $this->Articles->get(2);
        pr($data1->title_slug);
        pr(json_encode($data1, JSON_PRETTY_PRINT));
        
        
        
        
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