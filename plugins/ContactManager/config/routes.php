<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'ContactManager',
    ['path' => '/contact-manager'],
    function (RouteBuilder $routes) {
        /**
         * learn tutorial https://book.cakephp.org/3.0/en/plugins.html#plugin-routes
         * try to create new plugin
         */
        
        /**
         * replace commented line and use 'ida_1' style
         * because you will get error "Record not found in table "contacts" with primary key [NULL]" which is the value does not passed into the view function
         */
        //$routes->get('/contacts/:id', ['controller' => 'Contacts', 'action' => 'view']);
//        $routes->connect(
//            '/contacts/:ida_1'
//            ,['controller' => 'Contacts', 'action' => 'view']
//            ,['ida_1' => '\d+', 'pass' => ['ida_1']]
//        );
        
        /**
         * comment the line below because its does not works
         * /contact-manager/contacts/index = will give error "Error: Create the class ContactManagerController below in file: src\Controller\ContactManagerController.php"
         * /contact-manager/contacts = will give error "/plugins/ContactManager/src\Controller\ContactsController.php." where the function name is blank "public function ()"
         * using style1.1 and 1.2 seems nice
         */
        //$routes->get('/contacts', ['controller' => 'Contacts']); //style 1.0
        $routes->get('/contacts', ['controller' => 'Contacts', 'action' => 'index']); //style 1.1
        $routes->get('/contacts/:action/*', ['controller' => 'Contacts']); //style 1.2
        
        //$routes->fallbacks(DashedRoute::class); //disabled according to the tutorial as URL stated above
    }
);
