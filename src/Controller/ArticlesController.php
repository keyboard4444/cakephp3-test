<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
//use Cake\Collection\Collection;
use Cake\Datasource\ConnectionManager;
use PHPHtmlParser\Dom;

class ArticlesController extends AppController
{
    /*
     * i want to download all top 100 song from 2010 until 2018
     * get the list, get the download url from youtube, download it
     */
    public function domparser(){
        
        $dom = new Dom;
        $dom->loadFromUrl('http://www.bobborst.com/popculture/top-100-songs-of-the-year/?year=2000');
        
        //$html = $a->outerHtml;
        
        //get the song table
        $a = $dom->find(".songtable")[0];
        
        //get each table row
        $b = $a->find("tbody tr");
        //pr(count($b));
        foreach($b as $key1 => $value1){
            
            $c = $value1->find("td");
            $d = trim($c[1]->innerHtml.' '.$c[2]->innerHtml).' lyric';
            //pr($d);
        }
        
        $dom->loadFromUrl('https://www.youtube.com/results?search_query=Creed+Higher+lyric');
        
        $a = $dom->find("#video-title");
        $html = $a->outerHtml;
        
        echo $html;
        
        $this->render(DS.'blank');
    }
    
    
    /*
     * study cakephp collection: https://book.cakephp.org/3.0/en/core-libraries/collections.html
     */
    public function studycollection(){
        
        //in order to use collection, you need to "use Cake\Collection\Collection" first
        //Note that collection has 2 .php file, the CollectionTraits and CollectionInterface
        
        $this->loadModel("Contacts");
        $items = ['a' => 1, 'b' => 2, 'c' => 3];
        
        //Quick Example https://book.cakephp.org/3.0/en/core-libraries/collections.html#quick-example
        if( 0){
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
        }
        
        
        //Iterating https://book.cakephp.org/3.0/en/core-libraries/collections.html#iterating
        if( 0){
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
        }
        
        
        if( 0){
            pr("============sample raw data");
            $query = $this->Contacts
                ->find()
                ->where(['Contacts.id >=' => 1])
                ->contain(['Users', 'Articles'])
                ->toArray('name');
            pj($query);
        }
        
        
        //"Cake\Collection\Collection::extract"
        if( 0){
            pr("============Extract 1"); //get id-name mapping
            $data1 = $this->Contacts
                ->find()
                ->where(['Contacts.id >=' => 1])
                ->contain(['Users'])
                ->indexBy('id')
                ->extract('name')
                ->toArray();
            pr($data1);
        }    
            
        if( 0){
            pr("============Extract 2"); //get id-name mapping but index and extract later
            $data1 = $this->Contacts
                ->find()
                ->where(['Contacts.id >=' => 1])
                ->contain(['Users']);
            $data2 = $data1->indexBy('id')->extract('name')->toArray();
            pr($data2);
            
            //another experiment
            $data2 = $data1->map(function ($row) {
                    $new_row = array();
                    $new_row['id'] = $row['id'];
                    $new_row['name'] = $row['name'];
                    $new_row['age'] = $row['age'];
                    return $new_row;
                })
                ->indexBy('id')
                ->toArray();
            pr($data2);
            
            //another experiment
            $data2 = $data1->extract(function ($row) { //extract as callback
                return [
                    'id' => $row['id'], 
                    'name' => $row['name'], 
                    'age' => $row['age']
                ];
            })
            ->indexBy('id')
            ->toArray();
            pr($data2);
        }
        
        if( 0){
            pr("============Extract 4"); //extract and index is actually a callback function
            $data1 = $this->Contacts
                ->find()
                ->contain(['Users']);
            
            $data2 = $data1->extract(function ($row) { //extract as callback
                return $row['name'];
            })->toArray();
            pr($data2);
            
            $data2 = $data1->indexBy(function ($row) { //indexby as callback
                return $row['name'];
            })->extract('id')->toArray();
            pr($data2);
        }
        
        if( 0){
            pr("============Extract 3"); //get the mapping by sub
            $data1 = $this->Contacts
                ->find()
                ->contain(['Users']);
            
            $data2 = $data1->indexBy('user.id')->extract('user.email')->toArray(); //index mapping by sub
            pr($data2);
            
            $data2 = $data1->groupBy('user.id')->toArray(); //group by user_id, see 1 user_id has multiple contacts
            pj($data2);
        }
        
        if( 0){
            pr("============Extract 5"); //as per tutorial, using {*} to retrieve nested
            $data1 = $this->Contacts
                ->find()
                ->contain(['Users', 'Articles']);
            
            $data2 = $data1->extract('articles.{*}.slug')->toArray(); //index mapping by sub
            pr($data2);
        }
        
        if( 0){
            pr("============Combine"); //create a new collection made from keys and values in an existing collection. Both the key and value paths can be specified with dot notation path
            $data1 = $this->Contacts
                ->find()
                ->contain(['Users', 'Articles']);
            
//            $data2 = $data1->toArray();
//            pj($data2);
            
            $data2 = $data1->combine('id', 'name')->toArray();
            pr($data2);
            
            $data2 = $data1->combine('id', 'name', 'user_id')->toArray();
            pr($data2);
        }
        
        if( 0){
            pr("============Unfold"); //as per tutorial
            
            //standard example
            if( 0){
                $items = [[1, 2, 3], [4, 5]];
                $collection = collection($items);
                $new = $collection->unfold();
                pr($new->toArray());
            }
            
            //
            if( 0){
                
                //raw data
                $data1 = $this->Contacts
                    ->find()
                    ->contain(['Users']);
                
                //
                $data2 = $data1->combine('id', 'name', 'user_id')->toArray();
                pr($data2);
                $data3 = collection($data2); //somehow unfold(...) cannot be chain
                pr($data3->unfold()->toArray());
                
                //
                $oddNumbers = [1, 3, 5, 7];
                $collection = collection($oddNumbers);
                $new = $collection->unfold(function ($oddNumber) {
                    yield $oddNumber;
                    yield $oddNumber + 1;
                });
                $result = $new->toList();
                pr($result);
            }
        }
            
        if( 0) {
            pr("============chunk"); //as per tutorial
            
            //as per tutorial
            if (0) {
                $items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
                $collection = collection($items);
                $chunked = $collection->chunk(2);
                pr($chunked->toList());
            }
            
            $data1 = $this->Articles->find();
            
            //record set can also be chunk
            if (0) {
                $data2 = $data1->chunk(2);
                pj($data2);
            }
            
            //as per tutorial, batch processing
            if (0) {
                $data2 = $data1->map(function ($article) {
                    $article->test = 'hello';
                    return $article;
                })
                ->chunk(4)
                ->each(function ($batch) {
                    pj($batch);
                });
            }
            
            //chunk with keys, for associative arrays
            if (1) {
                
                $data1 = $this->Articles->find()->where([
                    'Articles.id >=' => 3
                ]);
            
                //there is differences between chunk using toArray() and toList(), seems better using toList()
                if( 0){
                    $data2 = $data1->extract('slug');
                    pr("===raw data");
                    pr($data2->toArray());
                    pr("===chunk->toArray");
                    pr($data2->chunk(3)->toArray());
                    pr("===chunk->toList");
                    pr($data2->chunk(3)->toList());
                    pr("===chunkWithKeys->toArray");
                    pr($data2->chunkWithKeys(3)->toArray());
                    pr("===chunkWithKeys->toList");
                    pr($data2->chunkWithKeys(3)->toList());
                }
                
                //compare differences with top and each others
                if( 1){
                    $data2 = $data1->indexBy('id')->extract('slug');
                    pr("===raw data");
                    pr($data2->toArray());
                    pr("===chunk->toArray");
                    pr($data2->chunk(3)->toArray());
                    pr("===chunk->toList");
                    pr($data2->chunk(3)->toList()); //best result but not preserve key
                    pr("===chunkWithKeys->toArray");
                    pr($data2->chunkWithKeys(3)->toArray());
                    pr("===chunkWithKeys->toList");
                    pr($data2->chunkWithKeys(3)->toList()); //best result to preserve key
                }
            }
        }
            
            
        //Filtering https://book.cakephp.org/3.0/en/core-libraries/collections.html#filtering
        if( 0){
            pr("============FILTERS");
            
            $data1 = $this->Articles->find()->where([
                'Articles.id >=' => 1
            ]);

            //some basic example
            if( 0){
                $data2 = $data1->filter(function ($articles, $key) {
                
                    //you can view the data here
                    //pr($key);
                    //pj($articles);

                    //return false; //will return blank since all no match
                    return true; //will return all because all TRUE=matched
                });
                pr("final results 1");
                pr($data2->toArray());
            }
            
            
            //slightly complex example?
            if( 1){
                $data2 = $data1->filter(function ($articles, $key) {
                
                    $finally_return_as = false;

                    if( $articles->id >= 3 && $articles->id <= 5){
                        $finally_return_as = true;
                    }

                    return $finally_return_as;
                });
                pr("final results 2");
                pr($data2->toArray());
            }
        }
        
        
        //match, first match, every & some = lazy to do
        
        
        //data aggregation, https://book.cakephp.org/3.0/en/core-libraries/collections.html#aggregation
        if( 0){
            pr("============aggregation");
            
            $data1 = $this->Contacts->find()->where([
                'Contacts.id >=' => 1
            ])
            ->contain('Articles');
//            pj($data1);
            
            //REDUCE, process the array into something summarized format (aka aggregation)
            if( 0){
                $data2 = $data1->reduce(function ($accumulated, $contact) {
                    
                    $accumulated['total'] += $contact->age;
                    $accumulated['raw_data'][] = $contact->age;
                    
                    return $accumulated;
                }, [
                    'total' => 0,
                    'raw_data' => []
                ]);
                pr("===reduced");
                pj($data2);
            }
            
            //MIN
            if( 0){
                $data2 = $data1->min('age'); //select the minimum age
                pj($data2);
            }
            
            //MAX
            if( 0){
                $data2 = $data1->max(function ($contacts) { //select the maximum age + using callback
                    return $contacts->age;
                });
                pj($data2);
            }
            
            //SUMOF
            if( 0){
                $data2 = $data1->sumOf('age'); //also can use sub
                pj($data2);
            }
            
            //AVERAGE
            if( 0){
                $data2 = $data1->avg('age'); //also can use sub
                pj($data2);
            }
            
            //MEDIAN
            if( 1){
                $data2 = $data1->median('age'); //also can use sub
                pj($data2);
            }
        }
        
        
        //Grouping and Counting https://book.cakephp.org/3.0/en/core-libraries/collections.html#grouping-and-counting
        if( 1){
            
            pr("============Grouping and Counting");
            
//            $data1 = $this->Contacts->find()->where([
//                'Contacts.id >=' => 1
//            ])
//            ->contain(['Articles', 'Users']);
            
            if(0){
                $data1 = $this->Contacts->find()->where([
                    'Contacts.id >=' => 1
                ])
                ->contain(['Users']);
                
                $data2 = $data1->groupBy('user_id');
                pj($data2);
            }
            
            if(0){
                //if belongsTo you can use sub like user.id
                $data1 = $this->Contacts->find()->where([
                    'Contacts.id >=' => 1
                ])
                ->contain(['Users']);
                
                $data2 = $data1->groupBy('user.id');
                pj($data2->toArray());
            }
            
            if(0){
                //but if hasMany, you cant sub
                $data1 = $this->Articles->find()->where([
                    'Articles.id >=' => 1
                ]);
                
                $data2 = $data1->groupBy('rating');
                pj($data2->toArray());
                
                $data2 = $data1->groupBy('user_id');
                pj($data2->toArray());
            }
            
            //example of using function
            if(0){
                $data1 = $this->Articles->find()->where([
                    'Articles.id >=' => 1
                ]);
                
                $data2 = $data1->groupBy(function ($data2_sub) {
                    if( $data2_sub->rating >= 4){
                        return 'good';
                    }
                    else {
                        return 'bad'; //ps: if you did not return anything, it will be blank key
                    }
                });
                pj($data2->toArray());
            }
            
            //countBy
            if(1){
                $data1 = $this->Articles->find()->where([
                    'Articles.id >=' => 1
                ]);
                
                $data2 = $data1->countBy(function ($data2_sub) {
                    if( $data2_sub->rating >= 4){
                        return 'good';
                    }
                    else {
                        return 'bad'; //ps: if you did not return anything, it will be blank key
                    }
                });
                pj($data2->toArray());
                
                $data2 = $data1->countBy('rating');
                pj($data2->toArray());
            }
        }


        $this->render(DS.'blank');
    }
    
    /**
     * study query builder tutorial at https://book.cakephp.org/3.0/en/orm/query-builder.html
     */
    public function studyquerybuilder(){
        
        $this->loadModel("Contacts");
        
        
        //ORM object is lazy, means the SQL is just prepared and not going to executed unless
        if( FALSE){
            
            //this will not execute and SQL statements (can check with Cake Debug Kit - SQL Log)
            $query = $this->Articles->find(); 
            $query->select(['id', 'title', 'slug']);
            $query->where(['Articles.id >=' => 1]);
            $query->order(['Articles.id DESC']);
            $query->enableHydration(false); //true return object, false return array
            
            //this one will not trigger execute, dont get confused
//            pr($query);
//            dd($query);
            
            //below this will trigger execute the SQL, possibly many more but below is what i know
//            pj($query);
//            $query->all();
//            $query->toList();
//            pr($query->toArray());
//            $query->first();
//            foreach($query as $key1 => $value1){}
//            pr($query->extract('slug')->toArray());
//            $query->execute();
        }
        
        
        //same like top, but try to do more advance query which learn from the API https://api.cakephp.org/3.6/class-Cake.ORM.Query.html
        if( 1){
            
            $query = $this->Articles->find();
            
            //at the end of the query, there will be 'HELLO WORLD'
//            $query->epilog('HELLO WORLD');
            
            //will do "SELECT Articles.id AS `helloworld`, ..." but somehow helloworld value cannot be retrieve
//            $query->modifier(['Articles.id AS `helloworld`', ',']);
            
            //example of using QueryExpression
            $myQueryExpression1 = $query->newExpr("SUM(Articles.id)");
            //$myQueryExpression2 = $query->newExpr('CASE WHEN Articles.id > 3 THEN "The quantity is greater than 30" WHEN Articles.id <= 3 THEN "The quantity is 30" ELSE "The quantity is something else" END');
            $query->select(['hiworld' => $myQueryExpression1]);
            
            //using alias, but not sure what is the purposes
//            $query->select($query->aliasField('title', 'Articles'));
            
            //using alias, but not sure what is the purposes
//            $query->select($query->aliasFields(['SUM(id)', 'title'], 'Articles'));
            
            //will not process the field type eg: created_date will not convert into FrozenTime Object
//            $query->disableResultsCasting();
            
            //see what value has been set into "$query"
//            $query->select(['id', 'title', 'slug']);
//            pr($query->clause('select'));
            
            $data1 = $query->toArray();
            pr($data1);
        }
        
        
        //some sample using raw sql, https://book.cakephp.org/3.0/en/orm/database-basics.html
        if( 0){
            
            $connection = ConnectionManager::get('default'); //you need to "use Cake\Datasource\ConnectionManager;" in order to use this
            
            /*
             * query VS execute VS prepare
             * query    = will execute the SQL immediately  + cannot pass parameter
             * execute  = will execute the SQL immediately  + can pass parameter
             * prepare  = will execute the SQL later        + can pass parameter
             *  *if using prepare, once all the parameter is set, execute the prepare using ->execute()
             * newQuery = will execute the SQL later        + can pass parameter
             */
            
            //query
            if( FALSE){
                $query = $connection->query("SELECT * FROM articles"); //will execute the SQL as SQL LOG from DebugKit
                pr($query); //will return Cake\Database\Log\LoggingStatement Object
                pj($query); //will return blank
                
                //to get raw data, use foreach
//                foreach ($query as $row) { //you can only access the data using foreach. or maybe there is another way
//                    pr($row); //please check the result quite weird
//                }
                
                //git filtered data use fetch(...) or fetchAll(...)
                $row = $query->fetch('assoc'); //'assoc'=return column name, blank=return array list
                pr($row);
                
                $rows = $query->fetchAll('assoc');
                pr($rows);
            }
            
            //execute
            if( FALSE){
                $query = $connection->execute("SELECT * FROM articles WHERE id>= :article_id", [ //will execute the SQL as SQL LOG from DebugKit
                    'article_id' => 2
                ]);
                
                $rows = $query->fetchAll('assoc');
                pr($rows);
                
                $rows = collection($rows); //seems like the raw sql does not collection supported by default (unlike ORM is default collection supported)
                $data1 = $rows->extract('title');
                pr($data1->toArray());
            }
            
            //prepare
            if( FALSE){
                $query = $connection->prepare("SELECT * FROM articles WHERE id>= :article_id"); //will not execute the SQL until you do "$query->execute();"
                $query->bindValue('article_id', 2, 'integer');
                $query->execute();
                
                $rows = collection($query->fetchAll('assoc')); //seems like this way is much better
                pr($rows->toArray());
            }
            
            //new query
            if( TRUE){
                
                $query = $connection //will not execute the SQL until you do "$query->execute();"
                    ->newQuery()
                    ->select('*')
                    ->from('articles')
                    ->where([
                        'id >=' => 2
                    ]);
                $rows = collection($query->execute()->fetchAll('assoc')); //the way it handle using new query is little bit different, and collection still manual call
                
                pr($rows->toArray());
                pr($rows->extract('title')->toArray());
            }
        }
        
        
        //try to mix "ORM query builder" with "Database Basics"
        if( 0){
            $connection = ConnectionManager::get('default');
            
            $query = $connection
                ->newQuery()
                ->select('*')
                ->from('articles');
            pr($connection);
            pr($query->execute());
//            pr($query->execute()->fetchAll('assoc'));
            pr($this->Articles->find());
        }
        
        
        
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
        if( FALSE){
            $data1 = $this->Contacts->find()->extract('name');
            pr($data1); //Return Collection-Iterator-ExtractIterator Object
            pj($data1);
        }
        
        
        
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