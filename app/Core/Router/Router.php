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

        if (sizeof($args) == 2)
            [$path, $controllerMethod] = $args;
        else
            [$path, $controllerMethod, $middleware] = $args;

        self::$routes[strtoupper($httpVerb)][$path] = $controllerMethod;
        if (!empty($middleware)) self::$routes[strtoupper($httpVerb)][$path] = [array_values($middleware)[0] => $controllerMethod];

        return $this;
    }
}