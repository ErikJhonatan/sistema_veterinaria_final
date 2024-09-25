<?php

namespace App\Http\Helpers;

use Session;
use Cookie;
use Str;
use DB;

class Prices {
    // ---------------------------------------------------
    // Símbolo de moneda                                //
    // ---------------------------------------------------

    public static function symbol($symbol = 'S/.') {
        return $symbol;
    }

    // ---------------------------------------------------
    // Formatear precios para las vistas                //
    // ---------------------------------------------------

    public static function format($price, $decimals = 2) {
        return number_format($price, $decimals, ',', '');
    }
}
