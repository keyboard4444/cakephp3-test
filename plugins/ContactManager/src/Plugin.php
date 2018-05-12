<?php

namespace ContactManager;

use Cake\Core\BasePlugin;

/**
 * Plugin for ContactManager
 */
class Plugin extends BasePlugin
{
    
    //add below example copy from https://book.cakephp.org/3.0/en/plugins.html#plugin-objects
    
    public function middleware($middleware)
    {
        // Add middleware here.
        return $middleware;
    }

    public function console($commands)
    {
        // Add console commands here.
        return $commands;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        // Add constants, load configuration defaults.
        // By default will load `config/bootstrap.php` in the plugin.
        parent::bootstrap($app);
    }

    public function routes($routes)
    {
        // Add routes.
        // By default will load `config/routes.php` in the plugin.
        parent::routes($routes);
    }
}
