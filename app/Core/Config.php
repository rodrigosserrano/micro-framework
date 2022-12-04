<?php

namespace App\Core;

class Config
{
    public static ?array $dbConfig = [];

    public static function setDbConfig(array $config = [
        'DB_CONN' => '',
        'DB_HOST' => '',
        'DB_PORT' => '',
        'DB_USER' => '',
        'DB_PASS' => '',
        'DB_NAME' => '',
    ]) : void
    {
        self::$dbConfig = $config;
    }
}
