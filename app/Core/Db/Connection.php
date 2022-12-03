<?php

namespace App\Core\Db;

use App\Core\Config;
use PDO;

class Connection
{
    private static $conn = null;

    public static function conn() {
        if (!self::$conn) {
            $config = Config::getDbConfig();
            $dsn = "{$config['DB_CONN']}:host={$config['DB_HOST']};dbname={$config['DB_NAME']};port={$config['DB_PORT']}";

            self::$conn = new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);

            return self::$conn;
        }
    }
}