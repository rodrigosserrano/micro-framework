<?php
namespace App\Core\Router;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\LoadController;
use App\Core\MapClass;

class RouterInit
{
    public static function run(): void
    {
        try {
            $routerMaped = new RouterTreait();
            $controllerMethod = $routerMaped->get();

            /** Middleware layer
             * Middleware acts at the beginning, before load controller
             * Initialize request too
             */
            $request = new Request();
            $controllerMethod = self::_callMiddleware($controllerMethod, $request);

            $loadController = new LoadController();
            $loadController->load($controllerMethod);
        } catch (\Exception $e) {
            (new Response($e->getMessage(), $e->getCode()))->send();
        }
    }

    private static function _callMiddleware(array|string $controllerMethod, Request $request) : string
    {
        if (!is_array($controllerMethod)) return $controllerMethod;

        $middleware = array_keys($controllerMethod)[0];
        $controllerMethod = $controllerMethod[$middleware];

        $middlewareNamespace = MapClass::$mapedClasses[$middleware];
        (new $middlewareNamespace)->handle($request);

        return $controllerMethod;
    }
}