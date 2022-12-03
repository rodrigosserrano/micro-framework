<?php

namespace App\Core;

use App\Routes\Routes;

class LoadController
{
    /**
     * TODO: comment this
     */
    public function load(string $router) : void
    {
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
        $uriRoute = array_search($router, Routes::get()[ServerParams::requestType()]); // Here I get the Path based on "Controller@method" received by param and request method
        $uriRoute = array_filter(explode('/', $uriRoute)); // explode string to array and filter to remove empty positions
        $uri = array_filter(explode('/', ServerParams::Uri())); // explode string to array and filter to remove empty positions

        // /user/232 <- this is Uri
        // /user/[0-9]+   <- This is Uri Route
        $params = array_diff($uri, $uriRoute); // get the difference between arrays
        sort($params); // used sort to rearrange the positions
        return $params;
    }
}