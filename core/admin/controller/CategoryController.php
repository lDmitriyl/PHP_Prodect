<?php


namespace core\admin\controller;


use core\user\model\Category;
use core\user\model\Product;

class CategoryController extends BaseAdmin
{

    public function index(){

        $this->template = 'core/admin/view/category/index';

        $categories = Category::instance()->getCategories();

        return ['categories' => $categories];
    }

    public function show(){

        $this->template = 'core/admin/view/category/show';

        $category = Category::instance()->getCategories($this->parameters['category_id']);

        $categoryProductsCount = Product::instance()->getCategoryProductsCount($this->parameters['category_id']);

        return ['category' => $category, 'categoryProductsCount' => $categoryProductsCount];

    }

    public function create(){

        $this->template = 'core/admin/view/category/form';

        if($this->isPost()){

            $this->clearPostFields();

            $this->createFiles('categories');

            Category::instance()->createCategory($_POST, $this->messages, $this->fileArray['image']) ? $this->redirect(PATH . 'admin/categories') : $this->redirect();
        }
    }

    public function update(){

        $this->template = 'core/admin/view/category/form';
        $this->table = 'categories';

        $category = Category::instance()->getCategories($this->parameters['category_id']);

        if($this->isPost()) {

            $this->clearPostFields();

            $this->createFiles('category', $_POST['id']);

            Category::instance()->updateCategory($_POST, $this->messages, $this->fileArray['image']) ?
                $this->redirect(PATH . 'admin/categories') : $this->redirect();

        }

        return ['category' => $category];
    }

    public function delete(){

        //Property::instance()->deleteProperty($this->parameters['id'], $this->messages);

        $this->redirect();

    }

}