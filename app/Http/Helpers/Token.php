<?php

namespace App\Http\Helpers;

use Session;
use Cookie;
use Str;
use DB;

class Token {
    // ---------------------------------------------------
    // Generar token                                    //
    // ---------------------------------------------------

    public static function create($size = 32, $mayus = false) {
        $str = Str::random(intval($size));

        if ($mayus) {
            $str = mb_strtoupper($str);
        }

        return $str;
    }

    // ----------------------------------------------------
    // Generar una letra aleatoria del alfabeto          //
    // ----------------------------------------------------

    public static function letter() {
        $num 					= mt_rand(0, 25);
        $a_z 					= trim("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
        $letra					= $a_z[$num];

        return $letra;
    }

    // ----------------------------------------------------
    // Generar string aleatorio                          //
    // ----------------------------------------------------

    public static function string(int $longitud = 6) {
        $string = str_shuffle('abcdefghijkmnopqrstuvwxyz');

        return substr($string, 0, $longitud);
    }
}
