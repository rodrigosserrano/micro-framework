<?php

namespace App\Core\Db;

use PDO;

class Connection
{
    private static ?PDO $instanceConn = null;

    public static function conn(): PDO
    {

        if (!self::$instanceConn) {

            $dsn = getenv('DB_CONN').":host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME').";port=".getenv('DB_PORT');

            self::$instanceConn = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$instanceConn;
    }

    public function __clone(): void
    {
        if (self::$instanceConn) throw new \Exception('Cant clone instance of connection');
    }
}