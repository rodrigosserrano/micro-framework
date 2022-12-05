<?php
require '../vendor/autoload.php';
require 'Routes/Routes.php';
session_start();

use App\Core\Http\Request;
use App\Core\MapClass;
use App\Core\Router\RouterInit;

#################### ENVS ######################
## CONFIG DATABASE CONNECTION
putenv('DB_CONN=pgsql');
putenv('DB_HOST=127.0.0.1');
putenv('DB_PORT=5432');
putenv('DB_USER=postgres');
putenv('DB_PASS=1234');
putenv('DB_NAME=databasetest');

## EXPIRE TOKEN
putenv('TOKEN_EXPIRES=1 hour');
################################################

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
