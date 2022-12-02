<?php

namespace App\core\router;

use App\core\LoadController;

class Router
{
    public static function run(): void
    {
        try {
            $routerMaped = new RouterTreait();
            $router = $routerMaped->get();

            $loadController = new LoadController();
            //TODO: Middleware
            $loadController->load($router);
        } catch (\Exception $e) {
            \UtilsHelpers::responseJson($e->getMessage(), $e->getCode());
        }
    }
}