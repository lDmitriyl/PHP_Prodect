<?php


namespace core\admin\controller;


use core\user\model\Product;
use core\user\model\productOffer;
use core\user\model\Property;
use core\user\model\PropertyOption;

class ProductOfferController extends BaseAdmin
{

    public function index(){

        $this->template = 'core/admin/view/productOffer/index';

        $productOffers = ProductOffer::instance()->getProductOffers($this->parameters['product_id']);
        $product = Product::instance()->getProduct($this->parameters['product_id'])[0];

        return ['productOffers' => $productOffers, 'product' => $product];
    }

    public function show(){

        $this->template = 'core/admin/view/productOffer/show';

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['id'])[0];

        return ['productOffer' => $productOffer];
    }

    public function create(){

        $this->template = 'core/admin/view/productOffer/form';

        $productProperties = Property::instance()->getProductProperties($this->parameters['product_id']);
        $propWithOptions = Property::instance()->getPropertyWithOptions($productProperties);

        if($this->isPost()){

            $this->clearPostFields();

            ProductOffer::instance()->createProductOffer($_POST, $this->messages) ?
                $this->redirect(PATH . 'admin/product_offers') : $this->redirect();
        }

        return ['propWithOptions' => $propWithOptions];
    }

    public function update(){
        $this->template = 'core/admin/view/productOffer/form';
        $this->table = 'products';

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['id'])[0];
        $productProperties = Property::instance()->getProductProperties($this->parameters['product_id']);
        $productOfferOptions = PropertyOption::instance()->getProductOfferOptions($productOffer['id']);
        $propWithOptions = Property::instance()->getPropertyWithOptions($productProperties);

        if($this->isPost()) {

            $this->clearPostFields();

            ProductOffer::instance()->updateProductOffer($_POST, $this->messages) ?
                $this->redirect(PATH . 'admin/product_offers/product_id/' . $_POST['product_id']) : $this->redirect();

        }

        return ['productOffer' => $productOffer, 'productProperties' => $productProperties,
            'propWithOptions' => $propWithOptions, 'productOfferOptions' => $productOfferOptions];
    }

    public function delete(){

        ProductOffer::instance()->deleteProductOffer($this->parameters['id'], $this->messages);

        $this->redirect();

    }

}