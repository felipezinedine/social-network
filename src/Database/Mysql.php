<?php 

namespace Src\Database;

use FFI\Exception;
use PDO;

class Mysql 
{   
    public static $pdo;

    public static function connect() {
        if(self::$pdo == null) {
            try {
                self::$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME , DB_USER, DB_PASS, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ]);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo 'Erro ao se conectar com o banco de dados ' . $e->getMessage();
            }
        }
        return self::$pdo;
    }
}