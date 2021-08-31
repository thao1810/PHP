<?php
namespace MVC\config;
use PDO;

class Database
{
    private static $bdd = null;

    private function __construct() {
    }

    public static function getBdd() {
        if(is_null(self::$bdd)) {
            self::$bdd = new PDO("mysql:host=localhost:3307;dbname=php_mvc", 'root', '');
        }
        return self::$bdd;
    }
}
?>