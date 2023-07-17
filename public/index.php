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
$request = new Core\Http\Request();

// Add the routes
$router->add('', ['directory' => 'Admin', 'controller' => 'Auth', 'action' => 'login']);
$router->add('admin', ['directory' => 'Admin', 'controller' => 'Admin', 'action' => 'index']);

$router->add('{controller}/{action}');
$router->add('{directory}/{controller}/{action}');

$router->dispatch($request);