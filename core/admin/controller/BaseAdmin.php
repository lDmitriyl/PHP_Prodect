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

        if(!empty($_POST['js-sorting']) && $this->fileArray){

            foreach ($_POST['js-sorting'] as $key => $item){

                if(!empty($item) && !empty($this->fileArray[$key])){

                    $fileArr = json_decode($item);

                    if($fileArr){

                        $this->fileArray[$key] = $this->sortingFiles($fileArr, $this->fileArray[$key]);

                    }

                }

            }

        }

        foreach ($this->fileArray as $row => $file){

            if(is_array($file)) $this->fileArray[$row] = json_encode($file);
            else $this->fileArray[$row] = addslashes($file);

        }
    }

    protected function sortingFiles($fileArr, $arr){

        $res = [];

        foreach ($fileArr as $file){

            if(!is_numeric($file)){

                $file = substr($file, strlen(PATH . UPLOAD_DIR));

            }else{

                $file = $arr[$file];

            }

            if($file && in_array($file, $arr)){

                $res[] = $file;

            }

        }

        return $res;

    }

    protected function checkFiles($id){

        if($id){

            $arrKeys = [];

            if(!empty($this->fileArray)) $arrKeys = array_keys($this->fileArray);

            if(!empty($_POST['js-sorting'])) $arrKeys = array_merge($arrKeys, array_keys($_POST['js-sorting']));

            if($arrKeys){

                $arrKeys = array_unique($arrKeys);

                $data = $this->model->getFiles($this->table, $arrKeys, $id);

                if($data){

                    $data = $data[0];

                    foreach ($data as $key => $item){

                        if((!empty($this->fileArray[$key]) && is_array($this->fileArray[$key])) || !empty($_POST['js-sorting'][$key])){

                            $fileArr = json_decode($item);

                            if($fileArr){

                                foreach ($fileArr as $file)
                                    $this->fileArray[$key][] = $file;

                            }

                        }elseif(!empty($this->fileArray[$key])){

                            @unlink($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . $item);

                        }

                    }

                }

            }

        }

    }

    public function deleteFile($product, $file){

        foreach ($product as $row => $item){

            if(isset($file[$row])){

                $file = base64_decode($file[$row]);

                $productImage = json_decode($item, true);

                if(is_array($productImage) || is_object($productImage)){

                    foreach ($productImage  as $key => $imgName){

                        if($file === $imgName){

                            unset($productImage[$key]);

                            break;

                        }

                    }

                    $data = $productImage ? json_encode($productImage) : NULL;

                }else{

                    $data = $file;

                }

                @unlink($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . $file);

                return $data;

            }
        }

        return NULL;
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