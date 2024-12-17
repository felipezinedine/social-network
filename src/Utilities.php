<?php 

namespace Src;

class Utilities
{
    public static function redirect(string $url) {
        echo '<script>window.location.href="'. $url .'"</script>';
        die; 
    }

    public static function redirect_back() {
        echo '<script>javascript:history.go(-1)</script>';
        die;
    }

    public static function alert(string $message) {
        echo '<script>alert("'. $message .'")</script>';
    }

    public static function getFirstAndSecondName(string $fullName): string
    {
        $nameParts = explode(' ', $fullName);

        if (count($nameParts) >= 2) {
            return $nameParts[0] . ' ' . $nameParts[1];
        }
        return $nameParts[0];
    }
}