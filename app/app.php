<?php

use App\Core\Http\Request;
use App\Core\MapClass;
use App\Core\Router\RouterInit;
use App\Core\DotEnv;

define('APP_PATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));

/**
 * Load envs
 */
DotEnv::load();

/**
 * Configure cors of application, you can enable or disable this
 * You can pass which links is allowed in .env, in ALLOWED_ORIGINS
 */
Request::cors(getenv('CORS'));

/**
 * Map classes for use the alias in another place, facilitating the call instance
 * This is used for core system, caution
 */
MapClass::$mapedClasses = [
    'auth' => 'App\Middlewares\\Authentication'
];

/**
 * Init all routes
 */
RouterInit::run();
