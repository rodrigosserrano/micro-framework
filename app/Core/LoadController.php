<?php

namespace App\Core;

use App\Core\Http\Request;
use App\Core\Router\Router;
use Exception;

class LoadController
{
    /**
     * ##### This method is not loaded case the middleware validation stops #####
     * This method load any controller, exploding the string passed in routes "Controller@method",
     * spliting the first part used for instance controller and second part used to call a method of controller
     * @throws Exception
     */
    public function load(string $controllerMethod): void
    {
        if(!str_contains($controllerMethod, '@')) throw new Exception("Invalid route or Controller@method in Routes", 500);
        [$controllerName, $method] = explode('@', $controllerMethod);

        $controllerNamespace = "App\Controllers\\$controllerName";
        if(!class_exists($controllerNamespace)) throw new Exception("Controller not found", 500);

        $controllerInstance = new $controllerNamespace;
        if(!method_exists($controllerInstance, $method)) throw new Exception("Method not found in controller $controllerName", 500);

        $args = $this->getParamsUri($controllerMethod);

        call_user_func([$controllerInstance, $method], ...$args);
    }

    private function getParamsUri(string $controllerMethod): array
    {
        $uriRoute = array_search($controllerMethod, Router::$routes[Request::requestType()]); // Here I get the Path based on "Controller@method" received by param and request method
        $uriRoute = array_filter(explode('/', $uriRoute)); // explode string to array and filter to remove empty positions
        $uri = array_filter(explode('/', Request::uri())); // explode string to array and filter to remove empty positions

        // /user/232 <- this is Uri
        // /user/[0-9]+   <- This is Uri Route
        $params = array_diff($uri, $uriRoute); // get the difference between arrays
        sort($params); // used sort to rearrange positions
        return $params;
    }
}