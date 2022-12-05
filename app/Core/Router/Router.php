<?php

namespace App\Core\Router;

use Error;

/**
 * @method get(string $path, string $controllerMethod, array $middleware = [])
 * @method post(string $path, string $controllerMethod, array $middleware = [])
 * @method patch(string $path, string $controllerMethod, array $middleware = [])
 * @method put(string $path, string $controllerMethod, array $middleware = [])
 * @method delete(string $path, string $controllerMethod, array $middleware = [])
 */
class Router
{
    public static ?array $routes = [];

    private static array $acceptedNames = ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'];

    /**
     * Make dynamic methods routes
     * @throws Error
     */
    public function __call($httpVerb, $args)
    {
        if (!in_array(strtoupper($httpVerb), self::$acceptedNames)) throw new Error('Invalid router method', 500);
        [$path, $controllerMethod, $middleware] = $args;

        self::$routes[strtoupper($httpVerb)][$path] = $controllerMethod;
        if (!empty($middleware)) self::$routes[strtoupper($httpVerb)][$path] = [array_values($middleware)[0] => $controllerMethod];

        return $this;
    }

    /**
     * Everything below will not be used, just kept to remember how it was before xD
     */

//    private static function configureRoutes(string $httpVerb, string $path, string $controllerMethod, ?array $middleware = [])
//    {
//        self::$routes[$httpVerb][$path] = $controllerMethod;
//        if (!empty($middleware)) self::$routes[$httpVerb][$path] = [array_values($middleware)[0] => $controllerMethod];
//    }

    /***************************************************************************************************/

//    public static function get(string $path, string $controllerMethod, ?array $middleware = []): void
//    {
//        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
//    }
//
//    public static function post(string $path, string $controllerMethod, ?array $middleware = []): void
//    {
//        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
//    }
//
//    public static function put(string $path, string $controllerMethod, ?array $middleware = []): void
//    {
//        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
//    }
//
//    public static function patch(string $path, string $controllerMethod, ?array $middleware = []): void
//    {
//        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
//    }
//
//    public static function delete(string $path, string $controllerMethod, ?array $middleware = []): void
//    {
//        self::configureRoutes(strtoupper(__FUNCTION__), $path, $controllerMethod, $middleware);
//    }
}