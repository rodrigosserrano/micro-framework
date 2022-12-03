<?php

namespace App\Core;

class Config
{
    public static function getDbConfig() {
        return [
            'DB_CONN' => 'pgsql',
            'DB_HOST' => '127.0.0.1',
            'DB_PORT' => '5432',
            'DB_USER' => 'postgres',
            'DB_PASS' => '123456',
            'DB_NAME' => 'mosyle',
        ];
    }
}

