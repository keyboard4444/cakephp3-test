<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

/**
 * prefix routing
 * 
 * http://localhost/cakephp3-test/admin/... will goes here
 */
Router::prefix('admin', function ($routes) {
    
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'index']);
    
    $routes->fallbacks(DashedRoute::class);
});

/**
 * A common use for routing = rename controllers and their actions
 * This is good if you want URL something like "/members/" but the the MVC is Users
 * 
 * Try type "http://localhost/cakephp3-test/cooks/commonrouting/i LIKE cakePHP/and i CANNOT lie"
 * 
 * Another example is lowercase + dashify
 */
Router::scope('/cooks', function ($routes) {
    
    $routes->setRouteClass(DashedRoute::class); //lowercased and dashed URLs when you generate the URL using html->link <-- this one not working or am i missing something?
    
    $routes->connect(
        '/:action/*', ['controller' => 'Articles']
    )->setPatterns(['id' => '[0-9]+']);
});


/**
 * set default controller to all "connect(...)" inside it to use "Articles"
 */
Router::scope('/arty', ['controller' => 'Articles'], function ($routes) {
    
    $routes->connect('/', ['action' => 'display']);
    //$routes->connect('/', ['controller' => 'Users', 'action' => 'display']); //this will generate error because it try to bypass default controller=Articles
    
    //not understand my self so not sure how to explain
//    pr(DashedRoute::class);
//    pr(InflectedRoute::class);
//    pr(Route::class);
//    $routes->connect('/:controller', ['action' => 'index'], compact('routeClass'));
//    $routes->connect('/:asdsadsa/:action/*', [], compact('routeClass'));
});


//not working
//connect to plugin https://book.cakephp.org/3.0/en/plugins.html#plugin-routes
//$routes->scope('/backend', function ($routes) { 
//    $routes->loadPlugin('ContactManager');
//});
//Router::plugin('ContactManager', ['path' => '/backend'], function ($routes) {
//    // Routes connected here are prefixed with '/debug_kit' and
//    // have the plugin route element set to 'DebugKit'.
////    $routes->connect('/:controller');
//});


Router::scope('/', function (RouteBuilder $routes) {
    
    //not working
//    $routes->scope('/backend', function ($routes) {
//        $routes->loadPlugin('ContactManager');
//    });


//    $routes->setRouteClass(DashedRoute::class);
//    $routes->connect('/:controller/:id', ['action' => 'view'])->setPatterns(['id' => '[0-9]+']);
    
    //double trail star route
    $routes->connect(
        '/verygreed/**',
        ['controller' => 'Articles', 'action' => 'doubletrailstarroute', 'send_default_variable_here']
    );
    
    $routes->connect('/', ['controller' => 'Articles', 'action' => 'display']);
    $routes->connect('/articles', ['controller' => 'Articles', 'action' => 'display']);
    
    $routes->connect('/test1', ['controller' => 'Articles', 'action' => 'test1']);
    $routes->connect('/mynameis', ['controller' => 'Articles', 'action' => 'gotmyownname'], ['_name' => 'whatismyname']);
    
    $routes->connect('/greedyurl/*', ['controller' => 'Articles', 'action' => 'greedyurl']);
    
    $routes->connect('/passme1', ['controller' => 'Articles', 'action' => 'passme', 'one']);
    $routes->connect('/passme2', ['controller' => 'Articles', 'action' => 'passme', 'two']);
    
    
    
    $routes->connect(
        '/articles/:ida_1'
        ,['controller' => 'Articles', 'action' => 'view']
        ,['ida_1' => '\d+', 'pass' => ['ida_1']]
    );
    
    
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
//    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'homea']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
   $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});




/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
