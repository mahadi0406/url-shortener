<?php
namespace App\Http\Utility;

class HashCodeGenerator
{
    const BASE = '8';
    private static $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public static function create()
    {
        $charactersLength = strlen(self::$chars);
        $randomString = '';
        for ($i = 0; $i < self::BASE; $i++) {
            $randomString .= self::$chars[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        
    }
}