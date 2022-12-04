<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Router\Router;

class LoadController
{
    private ?Request $_req;
    public function __construct(){
        $this->_req = new Request();
    }

    /**
     * TODO: comment this
     */
    public function load(string|array $router) : void
    {
        // Middleware acts at the beginning, before validantions controller
        if (is_array($router)) {
            $middleware = array_keys($router)[0];
            $router = $router[$middleware];

            $middlewareNamespace = MapClass::$mapedClasses[$middleware];
            (new $middlewareNamespace)->handle($this->_req);
        }

        if(!str_contains($router, '@')) throw new \Exception("Invalid route or Controller@method in Routes", 500);
        [$controllerName, $method] = explode('@', $router);

        $controllerNamespace = "App\Controllers\\$controllerName";
        if(!class_exists($controllerNamespace)) throw new \Exception("Controller not found", 500);

        $controllerInstance = new $controllerNamespace;
        if(!method_exists($controllerInstance, $method)) throw new \Exception("Method not found in controller $controllerName", 500);

        $args = $this->getParamsUri($router);

        call_user_func([$controllerInstance, $method], ...$args);
    }

    private function getParamsUri(string $router) : array
    {
        $uriRoute = array_search($router, Router::$routes[Request::requestType()]); // Here I get the Path based on "Controller@method" received by param and request method
        $uriRoute = array_filter(explode('/', $uriRoute)); // explode string to array and filter to remove empty positions
        $uri = array_filter(explode('/', Request::uri())); // explode string to array and filter to remove empty positions

        // /user/232 <- this is Uri
        // /user/[0-9]+   <- This is Uri Route
        $params = array_diff($uri, $uriRoute); // get the difference between arrays
        sort($params); // used sort to rearrange the positions
        return $params;
    }
}