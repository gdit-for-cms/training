<?php

require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();
// $router1 = new Core\Router();
$request = new Core\Http\Request();
// $appRequest = new App\Requests\AppRequest();

// Add the routes
$router->add('', ['controller' => 'Auth', 'action' => 'login']);
$router->add('{controller}/{action}');
    
// $router1->dispatch($appRequest);
$router->dispatch($request);
