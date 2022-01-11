<?php


namespace core\user\controller;


use core\base\controller\BaseController;
use core\base\settings\Settings;
use core\user\classes\CurrencyConversion;
use core\user\model\Model;
use core\user\model\User;

abstract class SiteController extends BaseController
{


    public function __construct(){

        $this->init();

        $this->currency();

        if(!$this->title) $this->title = 'Site';

        if(!$this->model) $this->model = Model::instance();

        if(!$this->messages) $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH . Settings::get('messages') . 'informationMessages.php';

        $this->_token = !empty($_SESSION['token']) ? $_SESSION['token'] : $this->createToken();

        if(isset($_COOKIE["remember"]) && !empty($_COOKIE["remember"])){

            $user = User::instance();
            $data = $user->getUser($_COOKIE["remember"]);

            if($data) $_SESSION['guest'] = $data[0];
        }
    }

    protected function outputData(){

        if(!$this->content){
            $args = func_get_arg(0);
            $vars = $args ? $args : [];

            $this->content = $this->render($this->template, $vars);
        }

        $this->header = $this->render(TEMPLATE . 'layout/header');
        $this->footer = $this->render(TEMPLATE . 'layout/footer');

        return $this->render(TEMPLATE . 'layout/master');

    }

    protected function currency(){

        $currencies = CurrencyConversion::getCurrencies();

        foreach ($currencies as $currency) {

            $_SESSION['currencies'][$currency['code']] = $currency['symbol'];

        }

    }

    protected function img($img = '', $tag = false){

        if(!$img && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . DEFAULT_IMAGE_DIRECTORY)){

            $dir = scandir($_SERVER['DOCUMENT_ROOT'] . PATH . UPLOAD_DIR . DEFAULT_IMAGE_DIRECTORY);

            $imgArr = preg_grep('/' . $this->getController() .'\./i', $dir) ?: preg_grep('/default\./i', $dir);

            $imgArr && $img = DEFAULT_IMAGE_DIRECTORY . '/' . array_shift($imgArr);

        }

        if($img){

            $path = PATH . UPLOAD_DIR . $img;

            if(!$tag){

                return $path;

            }

            echo '<img src="' . $path . '" alt="image" title = "image">';

        }

        return '';

    }
}