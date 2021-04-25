<?php


namespace core\user\controller;



use core\user\classes\CurrencyConversion;
use core\user\model\Currency;
use core\user\model\productOffer;

class IndexController extends SiteController
{

    public function inputData(){

        if(!$this->parameters['page']) $this->parameters['page'] = 1;

        $productOffers = ProductOffer::instance()->getProductOffers('', [($this->parameters['page'] - 1) * PAGINATION, PAGINATION]);

        $pageCount = (int)ceil($this->model->getCountEntity('product_offers')['count'] / PAGINATION);

        return ['productOffers' => $productOffers, 'pageCount' => $pageCount];

    }

    public function changeCurrency(){

        $_SESSION['currencyCode'] = $this->parameters['code'];

        $this->redirect();
    }

}