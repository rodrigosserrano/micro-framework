<?php

namespace App\Core\Router;

use Error;

/**
 * @method static get(string $path, string $controllerMethod, array $middleware = [])
 * @method static post(string $path, string $controllerMethod, array $middleware = [])
 * @method static patch(string $path, string $controllerMethod, array $middleware = [])
 * @method static put(string $path, string $controllerMethod, array $middleware = [])
 * @method static delete(string $path, string $controllerMethod, array $middleware = [])
 */
class Router
{
    public static ?array $routes = [];

    private static array $acceptedNames = ['GET', 'POST', 'PATCH', 'PUT', 'DELETE'];

    /**
     * Make dynamic methods routes
     * @throws Error
     */
    public static function __callStatic($httpVerb, $args)
    {
        if (!in_array(strtoupper($httpVerb), self::$acceptedNames)) throw new Error('Invalid router method', 500);

        if (sizeof($args) == 2)
            [$path, $controllerMethod] = $args;
        else
            [$path, $controllerMethod, $middleware] = $args;

        self::$routes[strtoupper($httpVerb)][$path] = $controllerMethod;
        if (!empty($middleware)) self::$routes[strtoupper($httpVerb)][$path] = [array_values($middleware)[0] => $controllerMethod];

//        return self;
    }
}