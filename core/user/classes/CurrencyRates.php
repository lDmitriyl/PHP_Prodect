<?php


namespace core\user\classes;


use core\user\model\Currency;

class CurrencyRates
{

    public static function getRates(){

        $url = 'http://api.exchangeratesapi.io/v1/latest';

        $options = [
            'access_key' => '287e54e72246b1ff87a2c5b01708eb84',
            'base' => 'EUR'
        ];

        $ch = curl_init($url . '?' . http_build_query($options));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if(isset($response['error'])){
            throw new \Exception('There is a problem with currency rate service');
        }

        foreach (CurrencyConversion::getCurrencies() as $currency){

            if(!$currency['is_main'] == 1){

                if(!isset($response['rates'][$currency['code']])){
                    throw new \Exception('There is a problem with currency ' . $currency['code']);
                }else{
                    Currency::instance()->updateCurrency($response['rates'][$currency['code']], $currency['id']);
                }
            }
        }

    }

}