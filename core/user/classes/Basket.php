<?php

namespace core\user\classes;

use core\user\model\Order;
use core\user\model\productOffer;

class Basket
{
    public $order;

    public function __construct(){

        $order = $_SESSION['order'];

        if(is_null($order)){

            $_SESSION['order']['products'] = [];

            if($_SESSION['guest']){
                $_SESSION['order']['user'] = $_SESSION['guest'];
            }

            $this->order = $_SESSION['order'];

        }else{
            $this->order = $order;
        }

    }

    public function getOrder()
    {
        $products = [];

        foreach ($this->order['products'] as $product){
            $products[] = $product[0];
        }

        $order = Order::instance()->getOrder(implode(',', $products));

        foreach ($order as &$item){

            foreach ($this->order['products'] as $product){
                if($item['id'] === $product[0]) $item['countInOrder'] = $product['count'];
            }

        }

        return $order;
    }

    public function addProduct($product){

        if($product['count'] == 0) return false;

        if($product['count'] == $this->order['products'][$product['id']]['count']) return false;

        if(array_key_exists($product['id'], $this->order['products']) === false){

            $_SESSION['order']['products'][$product['id']] = (array)$product['id'];
            $_SESSION['order']['products'][$product['id']]['count'] = 1;
        }else{

            $_SESSION['order']['products'][$product['id']]['count'] += 1;
        }

        return true;
    }

    public function removeProduct($product_id){

        $_SESSION['order']['products'][$product_id]['count'] -= 1;

        if($_SESSION['order']['products'][$product_id]['count'] == 0){
            unset($_SESSION['order']['products'][$product_id]);
        }
    }

    public function saveOrder($order, $data){

        $orderFullSum = $this->getFullSum($order);

        if(Order::instance()->saveOrder($orderFullSum, $data, $order)){

            if(ProductOffer::instance()->updatePOCount($order))

                return true;
        }

        return false;

    }

    public function getFullSum($products){

        $sum = 0;

        foreach ($products as $product){
            $sum += CurrencyConversion::convert($product['price']) * $product['countInOrder'];
        }

        return $sum;
    }

    public function countAvailable($products){

        foreach ($products as $product){
            if($product['count'] < $product['countInOrder']) return $product;
        }

        return false;
    }

    public function sendMail($order, $data){

        $message = "Ваш заказ №{$order['id']} принт на обработку";

        $from = "test@yandex.ru";

        $subject = "Заказ №{$order['id']} магазина TEST";
        $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

        $headers = "From: $from\r\nReply-to: $from\r\nContent-type:text\html; charset=utf-8\r\n";

        mail($data['mail'], $subject, $message, $headers);
    }

}