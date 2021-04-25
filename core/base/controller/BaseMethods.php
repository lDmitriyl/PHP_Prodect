<?php


namespace core\base\controller;


use core\user\classes\CurrencyConversion;

trait BaseMethods
{

    protected function clearStr($str){

        if(is_array($str)){

            foreach ($str as $key => $item) $str[$key] = $this->clearStr($item);

            return $str;
        }else{
            return trim(strip_tags($str));
        }
    }

    protected function clearNum($num){
        return (!empty($num) && preg_match('/\d/', $num)) ? preg_replace('/[^\d.]/', '', $num) * 1 : 0;
    }

    protected function isPost(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(!empty($_POST['_token'] && $this->tokensMatch($_POST['_token']))){
                return true;
            }

            $_SESSION['res']['warning'] = 'Отсутствует токен';

            $this->redirect();
        }
        return false;
    }

    protected function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    protected function redirect($http = false, $code = false){
        if($code){
            $codes = ['301' => 'HTTP/1.1 301 Move Permanently'];

            if($codes[$code]) header($codes[$code]);
        }

        if($http) $redirect = $http;
        else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;

        header('Location:' . $redirect);

        exit();
    }

    protected function getStyles(){

        if($this->styles){
            foreach ($this->styles as $style) echo '<link rel="stylesheet" href="' . $style . '">';
        }

    }

    protected function getScripts(){

        if($this->scripts){
            foreach ($this->scripts as $script) echo '<script src="' . $script . '"></script>';
        }

    }

    protected function writeLog($message, $file = 'log.txt', $event = 'Fault'){

        $dateTime = new \DateTime();

        $str = $event . ': ' . $dateTime->format('d-m-Y G:i:s') . ' - ' . $message . "\r\n";

        file_put_contents('log/' . $file, $str, FILE_APPEND);

    }

    protected function createToken($length = 32){
        $chars = '1234567890qazwsxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBYHNUJMIKOLP';
        $max = strlen($chars) - 1;
        $token = '';

        for($i = 0; $i < $length; ++$i){
            $token .= $chars[rand(0,$max)];
        }

        $token = md5($token.session_name());
        $_SESSION['token'] = $token;

        return $token;
    }

    protected function tokensMatch($token){
        return hash_equals($token, $_SESSION['token']);
    }

    protected function convertCurrency($price){
        return CurrencyConversion::convert($price);
    }

}