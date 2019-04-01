<?php

namespace Tools;

use Simplon\Mysql\PDOConnector;
use Simplon\Mysql\Mysql;

class DB
{
    public static $connection = null;

    private static $server = 'localhost';
    private static $user = 'root';
    private static $pass = 'p12300';
    private static $database = 'test';

    private static function connect()
    {
        $pdo = new PDOConnector(
            static::$server,
            static::$user,
            static::$pass,
            static::$database
        );

        $pdoConn = $pdo->connect('utf8', []); // charset, options

        static::$connection = new Mysql($pdoConn);
    }

    public static function connection()
    {
        if (!static::$connection) {
            static::connect();
        }
        return static::$connection;
    }
}