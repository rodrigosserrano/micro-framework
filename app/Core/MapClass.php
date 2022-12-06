<?php

namespace App\Core;

class MapClass
{
    /**
     * @param array $class - Receive per exemple ['auth' => 'App\Middlewares\\Authentication'] - array key is alias and value is the namespace
     */
    public static ?array $mapedClasses = [];
}