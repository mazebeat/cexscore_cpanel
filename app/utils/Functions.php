<?php namespace App\Util;

class Functions
{

    public static function printr($a)
    {
        echo "<pre>" . htmlspecialchars(print_r($a, true)) . "</pre>";
    }
} 