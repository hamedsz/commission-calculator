<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Euro
{
    public static function getRates(){
        Global $cachedResponse;

        if ($cachedResponse){
            $resp = $cachedResponse;
        }
        else{
            $resp = Http::get('https://developers.paysera.com/tasks/api/currency-exchange-rates')->json();
            $cachedResponse = $resp;
        }

        return $resp;
    }

    public static function convert($amount, $currency){

        $resp = self::getRates();

        $rate = $resp['rates'][$currency];

        return $amount / $rate;
    }

    public static function convertFromEuroTo($amount, $currency){
        $resp = self::getRates();

        $rate = $resp['rates'][$currency];

        return $amount * $rate;
    }

    public static function getRate($currency){
        $resp = self::getRates();

        return $resp['rates'][$currency];
    }
}
