<?php

@require_once 'config.php';

class Database{
    private static $connection;
    private static $config;

    private function __construct(){
        
    }

    public function __destruct(){
        if(!is_null(self::$connection)){
            self::$connection = null;
        }
    }

    public static function setConfig($config){
        self::$config = $config;
    }

    public static function getConnection(){
        self::setConfig(include 'config.php');

        if (self::$connection == null)
            self::createConnection();

        return self::$connection;
    }
    private static function createConnection(){
        $dbHost = self::$config['host'];
        $dbName = self::$config['name'];
        $dbUser = self::$config['user'];
        $dbPass = self::$config['pass'];

        try{
            self::$connection = new PDO("pgsql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo 'Connection failed' . $e->getMessage();
        }
    }
}