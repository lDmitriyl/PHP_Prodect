<?php


namespace core\admin\controller;


use core\user\model\Category;
use core\user\model\Product;
use core\user\model\Property;

class ProductController extends BaseAdmin
{
    public function index(){

        $this->template = 'core/admin/view/product/index';

        $products = Product::instance()->getProduct();

        return ['products' => $products];
    }

    public function show(){

        $this->template = 'core/admin/view/product/show';

        $product = Product::instance()->getProduct($this->parameters['id'])[0];

        return ['product' => $product];
    }

    public function create(){

        $this->template = 'core/admin/view/product/form';

        $categories = Category::instance()->getCategories();
        $properties = Property::instance()->getProperty();

        if($this->isPost()){

            $this->clearPostFields();

            Product::instance()->createProduct($_POST, $this->messages) ? $this->redirect(PATH . 'admin/products') : $this->redirect();
        }

        return ['category' => $categories, 'properties' => $properties];
    }

    public function update(){
        $this->template = 'core/admin/view/product/form';
        $this->table = 'products';

        $product = Product::instance()->getProduct($this->parameters['id'])[0];
        $categories = Category::instance()->getCategories();

        $properties = Property::instance()->getProperty();
        $productProperties = Property::instance()->getProductProperties($this->parameters['id']);

        if($this->isPost()) {

            $this->clearPostFields();

            $this->createFiles('products', $_POST['id']);

            Product::instance()->updateProduct($_POST, $this->messages) ?
                $this->redirect(PATH . 'admin/products') : $this->redirect();

        }

        return ['product' => $product, 'category' => $categories, 'properties' => $properties , 'productProperties' => $productProperties];
    }

    public function delete(){

        Product::instance()->deleteProduct($this->parameters['id'], $this->messages);

        $this->redirect();

    }
}