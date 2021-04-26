<?php


namespace core\user\controller;


use core\user\classes\Basket;
use core\user\classes\CurrencyConversion;
use core\user\model\productOffer;

class BasketController extends SiteController
{

    public function index(){

        if(!isset($_SESSION['order']['products']) || empty($_SESSION['order']['products'])){

            $_SESSION['res']['warning'] = $this->messages['emptyBasket'];

            $this->redirect(PATH);
        }

        $this->template = 'templates/basket';

        $order = (new Basket())->getOrder();

        $orderFullSum = (new Basket())->getFullSum($order);

        return ['order' => $order, 'orderFullSum' => $orderFullSum];
    }

    public function basketPlace(){

        $this->template = 'templates/order';

        $order = (new Basket())->getOrder();

        $orderFullSum = (new Basket())->getFullSum($order);

        $currency = CurrencyConversion::getCurrentCurrencyFromSession();

        return ['order' => $order, 'orderFullSum' => $orderFullSum, 'currency' => $currency];
    }

    public function basketConfirm(){

        if($this->isPost()){

            $this->clearPostFields();

            $basket = new Basket();

            $order = $basket->getOrder();

            $productNotAvailable = $basket->countAvailable($order);

            if($productNotAvailable){

                $_SESSION['res']['warning'] = $this->messages['ProductNotAvailable']. $productNotAvailable['product_name'];

                $this->redirect('/basket');
            }

            if($basket->saveOrder($order, $_POST)){

                $_SESSION['res']['success'] = $this->messages['createOrderSuccess'];

                unset($_SESSION['order']);

                $basket->sendMail($order, $_POST);

                $this->redirect(PATH);
            }

            $_SESSION['res']['warning'] = $this->messages['createOrderFail'];

            $this->redirect(PATH);
        }

    }

    public function addBasket(){

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['productOffer_id'])[0];

        $result = (new Basket())->addProduct($productOffer);

        if($result){
            $_SESSION['res']['success'] = $this->messages['addBasketProduct'] . $productOffer['product_name'];
        }else{
            $_SESSION['res']['warning'] = $productOffer['product_name'] . $this->messages['denyBasketProduct'];
        }

        $this->redirect();
    }

    public function removeBasket(){

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['productOffer_id'])[0];

        (new Basket())->removeProduct($this->parameters['productOffer_id']);

        $_SESSION['res']['success'] = $this->messages['removeBasketProduct'] . $productOffer['product_name'];

        $this->redirect();
    }

}