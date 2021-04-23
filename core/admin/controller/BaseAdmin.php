<?php

namespace core\admin\controller;

use core\base\controller\BaseController;
use core\admin\model\Model;
use core\base\settings\Settings;
use core\user\model\PropertyOption;
use core\user\model\User;
use libraries\FileEdit;

abstract class BaseAdmin extends BaseController
{
    protected $fileArray;

    public function __construct(){

        $this->init('admin');

        if(!$this->title) $this->title = 'admin';

        if(!$this->model) $this->model = Model::instance();

        if(!$this->messages) $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH . Settings::get('messages') . 'informationMessages.php';

        $this->_token = !empty($_SESSION['token']) ? $_SESSION['token'] : $this->createToken();

        if(isset($_COOKIE["remember"]) && !empty($_COOKIE["remember"])){

            $user = User::instance();
            $data = $user->getUser($_COOKIE["remember"]);

            if($data) $_SESSION['guest'] = $data[0];
        }
    }

    protected function outputData($data){

        if(!$this->content){

            $args = func_get_arg(0);
            $vars = $args ? $args : [];

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(ADMIN_TEMPLATE . 'layout/header');
        $this->footer = $this->render(ADMIN_TEMPLATE . 'layout/footer');

        return $this->render(ADMIN_TEMPLATE . 'layout/master');

    }

    protected function createFiles($directory, $id = NULL){

        $fileEdit = new FileEdit();

        $this->fileArray = $fileEdit->addFile($directory);

        if($id){

            $this->checkFiles($id);

        }
    }

    protected function checkFiles($id){

        if($id){

            $arrKeys = [];

            if(!empty($this->fileArray)) $arrKeys = array_keys($this->fileArray);

            if($arrKeys){

                $data = $this->model->getFiles($this->table, $arrKeys[0], $id);

                if($data){

                    $data = $data[0];

                    foreach ($data as $key => $item){

                        if(!empty($this->fileArray[$key])){

                            @unlink($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . $item);

                        }

                    }

                }

            }

        }

    }

    public function productOfferName($productOffer){

        $data = [];

        if($productOfferOptions = PropertyOption::instance()->getProductOfferOptions($productOffer['id'])){

            foreach ($productOfferOptions as $options)
                $data[] = $options['name'];
        }

        return implode(', ', $data);
    }




}