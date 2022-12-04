<?php
require '../vendor/autoload.php';
require 'Routes/Routes.php';
session_start();

use App\Core\Config;
use App\Core\Http\Request;
use App\Core\MapClass;
use App\Core\Router\RouterInit;

/**
 * Configuration of connection with database
 */
Config::setDbConfig([
    'DB_CONN' => 'pgsql',
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '5432',
    'DB_USER' => 'postgres',
    'DB_PASS' => '123456',
    'DB_NAME' => 'mosyle',
]);

/**
 * Configure cors of application, you can enable or disable this and pass which links is allowed
 */
Request::cors(true, ['http://127.0.0.1:8080']);

/**
 * Map classes for use the alias in another place, facilitating the call instance
 * This is used for core system, caution
 */
MapClass::map([
    'auth' => 'App\Middlewares\\Authentication'
]);

/**
 * Init all routes
 */
RouterInit::run();