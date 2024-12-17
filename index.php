<?php

use Src\Application;
use Src\Database\Mysql;

session_start();
date_default_timezone_set('America/Sao_Paulo');
require 'vendor/autoload.php';

define('INC_PATH_VIEW', 'http://localhost/estudos/social-network/src/Views/');
define('INC_PATH', 'http://localhost/estudos/social-network/');

//config banco de dados
define('HOST', 'localhost');
define('DB_NAME', 'social-network');
define('DB_USER', 'root');
define('DB_PASS', '');

Mysql::connect();

$app = (new Application())->load();

function view($filename) {
    $loadView = str_replace('.', '/', $filename);
    include 'Src/Views/'. $loadView . '.php';
}

function dd(mixed $code) {
    var_dump($code);die;
}
