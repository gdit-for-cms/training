<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// Load dotenv
$dotenv = Dotenv\Dotenv::createMutable(dirname(__DIR__)  . '/');
$dotenv->load();

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
$router->add('', ['controller' => 'Auth', 'action' => 'login']);
$router->add('{controller}/{action}');

if (isset($_REQUEST['data']) && empty($_SESSION['user'])) {
    $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
    $router->dispatch($request);
} else {
    $router->dispatch($request);
}
