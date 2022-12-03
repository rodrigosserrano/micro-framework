<?php

class UtilsHelpers
{
    public static function responseJson(string|array|object $response, ?int $statusCode = 200) : void
    {
        http_response_code($statusCode);
        echo json_encode([
            'data' => $response,
            'statusCode' => $statusCode
        ]);
    }

    public static function dd(mixed $var, ?bool $die = true) : void
    {
        echo "<pre>".print_r($var,1)."</pre><br>";
        if ($die) die();
    }
}