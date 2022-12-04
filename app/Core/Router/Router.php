<?php

namespace App\Core\Router;

use App\Core\Http\Request;

class Router
{
    public static ?array $routes = [];

    private static function configureRoutes(string $httpVerb, string $path, string $controllerMethod, ?array $middleware = [])
    {
        self::$routes[$httpVerb][$path] = $controllerMethod;
        if (!empty($middleware)) self::$routes[$httpVerb][$path] = [array_values($middleware)[0] => $controllerMethod];
    }

    /***************************************************************************************************/

    public static function get(string $path, string $controllerMethod, ?array $middleware = []) : void
    {
        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
    }

    public static function post(string $path, string $controllerMethod, ?array $middleware = []) : void
    {
        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
    }

    public static function put(string $path, string $controllerMethod, ?array $middleware = []) : void
    {
        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
    }

    public static function patch(string $path, string $controllerMethod, ?array $middleware = []) : void
    {
        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
    }

    public static function delete(string $path, string $controllerMethod, ?array $middleware = []) : void
    {
        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
    }
}