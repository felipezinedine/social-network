<?php 

namespace Src\Config;

class View 
{
    public static function make($filename) 
    {
        $loadView = str_replace('.', '/', $filename);
        include 'View/' . $loadView . '.php';
    }
}