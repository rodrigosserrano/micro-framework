<?php
namespace App\Core\Router;

use App\Core\Http\Response;
use App\Core\LoadController;

class RouterInit
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
            (new Response($e->getMessage(), $e->getCode()))->send();
        }
    }
}