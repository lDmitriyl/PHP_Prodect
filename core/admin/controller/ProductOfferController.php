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

        return ['productOffers' => $productOffers];
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

            $this->createFiles('productOffer/gallery_img');

            ProductOffer::instance()->createProductOffer($_POST, $this->fileArray , $this->messages) ?
                $this->redirect(PATH . 'admin/product_offers/product_id/' . $_POST['product_id']) : $this->redirect();
        }

        return ['propWithOptions' => $propWithOptions];
    }

    public function update(){

        $this->template = 'core/admin/view/productOffer/form';
        $this->table = 'product_offers';

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['id'])[0];
        $productOfferOptions = PropertyOption::instance()->getProductOfferOptions($productOffer['id']);

        $productProperties = Property::instance()->getProductProperties($this->parameters['product_id']);
        $propWithOptions = Property::instance()->getPropertyWithOptions($productProperties);

        if($this->isPost()) {

            $this->clearPostFields();

            $this->createFiles('productOffer/gallery_img', $_POST['id']);

            ProductOffer::instance()->updateProductOffer($_POST, $this->fileArray, $this->messages) ?
                $this->redirect(PATH . 'admin/product_offers/product_id/' . $_POST['product_id']) : $this->redirect();

        }

        return ['productOffer' => $productOffer, 'productProperties' => $productProperties,
            'propWithOptions' => $propWithOptions, 'productOfferOptions' => $productOfferOptions];
    }

    public function delete(){

        ProductOffer::instance()->deleteProductOffer($this->parameters['id'], $this->messages);

        $this->redirect();

    }

    public function deleteImages(){

        $productOffer = ProductOffer::instance()->getProductOffer($this->parameters['id'])[0];

        $id = $this->parameters['id'];

        array_shift($this->parameters);

        $images = $this->deleteFile($productOffer, $this->parameters);

        if(ProductOffer::instance()->updateImage('product_offers', array_keys($this->parameters)[0], $images, $id)){

            $_SESSION['res']['success'] = $this->messages['deleteImage'];

            $this->redirect();
        }

        $_SESSION['res']['success'] = $this->messages['deleteImageError'];
    }

}