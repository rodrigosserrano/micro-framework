<?php

namespace App\Core;

class ServerParams
{
    public static function requestType() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function Uri() : string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    public static function requestsTypesAcceptBody() : array
    {
        return ['POST', 'PATCH', 'PUT'];
    }
}