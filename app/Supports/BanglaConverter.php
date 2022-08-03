<?php

namespace App\Supports;

class BanglaConverter
{
    public static $bn = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'];

    public static $en = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

    public static function bn2en($number)
    {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function en2bn($number)
    {
        return str_replace(self::$en, self::$bn, $number);
    }
}
