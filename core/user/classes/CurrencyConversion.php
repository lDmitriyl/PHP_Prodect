<?php


namespace core\user\classes;


use core\user\model\Currency;
use libraries\DateFunctions;

class CurrencyConversion
{

    protected static $container;

    public static function loadContainer(){

        if(is_null(self::$container)){

            $currencies = Currency::instance()->getCurrencies();

            foreach ($currencies as $currency){
                self::$container[$currency['code']] = $currency;
            }
        }
    }

    public static function getCurrencies(){

        self::loadContainer();

        return self::$container;
    }

    public static function getCurrencyCodeFromSession(){
        return $_SESSION['currencyCode'] ?: $_SESSION['currencyCode'] = DEFAULT_CURRENCY_CODE;
    }

    public static function getCurrentCurrencyFromSession(){

        self::loadContainer();

        $currencyCode = self::getCurrencyCodeFromSession();

        foreach (self::$container as $currency) {

            if($currency['code'] === $currencyCode){
                return $currency;
            }

        }
    }

    public static function convert($sum, $originCurrencyCode = DEFAULT_CURRENCY_CODE, $targetCurrencyCode = null){

        self::loadContainer();

        $originCurrency = self::$container[$originCurrencyCode];

        if($originCurrency['code'] != DEFAULT_CURRENCY_CODE){

            if($originCurrency['rate'] == 0 ||
                strtotime((new DateFunctions())->startOfDay($originCurrency['updated_at'])) != strtotime(date("d-m-Y"))){

                CurrencyRates::getRates();
                $originCurrency = self::$container[$originCurrencyCode];

            }
        }

        if(is_null($targetCurrencyCode)){
            $targetCurrencyCode = self::getCurrencyCodeFromSession();
        }

        $targetCurrency = self::$container[$targetCurrencyCode];

        if($targetCurrency['code'] != DEFAULT_CURRENCY_CODE) {

            if ($targetCurrency['rate'] == 0 ||
                strtotime((new DateFunctions())->startOfDay($targetCurrency['updated_at'])) != strtotime(date("d-m-Y"))) {

                CurrencyRates::getRates();
                $targetCurrency = self::$container[$targetCurrencyCode];

            }
        }

        return round($sum / $originCurrency['rate'] * $targetCurrency['rate']);
    }

    public static function getCurrencySymbol(){

        self::loadContainer();

        $currencyFromSession = self::getCurrencyFromSession();

        $currency = self::$container[$currencyFromSession];

        return $currency['symbol'];
    }

    public static function getBaseCurrency(){

        self::loadContainer();

        foreach (self::$container as $currency) {

            if($currency['is_main'] == 1){
                return $currency;
            }

        }
    }

}