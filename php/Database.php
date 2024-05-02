<?php

class Database{
    private static $connection;
    private static $config;

    private function __construct(){
    }

    public function __destruct(){
        if(!is_null(self::$connection)){
            self::$connection->close();
        }
    }

    public function setConfig($config){
        self::$config = $config;
    }

    public static function getConnection(){
        if (self::$connection == null)
            self::createConnection();

        return self::$connection;
    }
    private static function createConnection(){
        $dbHost = self::$config['host'];
        $dbName = self::$config['name'];
        $dbUser = self::$config['user'];
        $dbPass = self::$config['pass'];

        self::$connection = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>