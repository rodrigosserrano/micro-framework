<?php

namespace App\Core;

class MapClass
{
    public static ?array $mapedClasses = [];

    /**
     * @param array $class - Receive per exemple ['auth' => 'App\Middlewares\\Authentication'] - array key is alias and value is the namespace
    */
    public static function map(array $class): void
    {
        self::$mapedClasses = $class;
    }
}