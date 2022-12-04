<?php

namespace App\Core\Db;

use App\Core\Config;
use PDO;

class Connection
{
    private static ?PDO $instanceConn = null;

    public static function conn() : PDO
    {
        if (!self::$instanceConn) {
            $config = Config::$dbConfig;
            $dsn = "{$config['DB_CONN']}:host={$config['DB_HOST']};dbname={$config['DB_NAME']};port={$config['DB_PORT']}";

            self::$instanceConn = new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$instanceConn;
    }

    public function __clone() : void
    {
        if (self::$instanceConn) throw new \Exception('Cant clone instance of connection');
    }
}