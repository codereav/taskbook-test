<?php

require __DIR__ . '/../vendor/autoload.php';
session_start();
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') or define('BASE_PATH', __DIR__ . DS . '..');

$config = require __DIR__ . DS . '..' . DS . 'config.php';
$routes = require __DIR__ . DS . '..' . DS . 'routes.php';

$auth = new \App\System\Auth($config);
$router = new App\System\Router($routes);
$database = new \App\System\Database($config['mysql']);
$view = new \App\System\View();

$app = new \App\System\Application($auth, $router, $database, $view);
$app->run();