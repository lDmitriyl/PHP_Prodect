<?php


namespace core\user\controller;


use core\base\controller\BaseController;
use core\base\settings\Settings;
use core\user\model\Model;

abstract class SiteController extends BaseController
{
    protected $model;

    protected $title;

    protected $messages;
    protected $settings;

    protected function inputData(){

        $this->init();

        $this->title = 'Site';

        if(!$this->model) $this->model = Model::instance();
        if(!$this->menu) $this->menu = Settings::get('projectTables');

        if(!$this->messages) $this->messages = include $_SERVER['DOCUMENT_ROOT'] . PATH . Settings::get('messages') . 'informationMessages.php';
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

    protected function execBase(){
        self::inputData();
    }

    protected function clearPostFields($settings = false, &$arr = []){

        if(!$arr) $arr = &$_POST;
        if(!$settings) $settings = Settings::instance();

        $validate = $settings::get('validation');

        foreach ($arr as $key => $item){

            if(is_array($item)){
                $this->clearPostFields($settings, $item);
            }else{
                if(is_numeric($item)){
                    $arr[$key] = $this->clearNum($item);
                }

                if($validate){

                    if($validate[$key]){
                        $answer = $key;

                        if($validate[$key]['crypt']){
                            $arr[$key] = md5($item);

                        }

                        if($validate[$key]['empty']) $this->emptyFields($item, $answer, $arr);
                        if($validate[$key]['trim']) $arr[$key] = trim($item);
                        if($validate[$key]['int']) $arr[$key] = $this->clearNum($item);
                        if($validate[$key]['email']) $this->Email($item, $answer, $arr);
                        if($validate[$key]['countMax']) $this->countChar($item, $validate[$key]['countMax'], $answer, 'max', $arr);
                        if($validate[$key]['countMin']) $this->countChar($item, $validate[$key]['countMin'], $answer, 'min', $arr);
                    }
                }
            }
        }

        if(isset($arr['pwd2'])) $this->checkPassword($arr);
        return true;
    }

    protected function emptyFields($str, $answer, $arr = []){

        if(empty($str)){
            $_SESSION['res']['answer'] = '<p class="alert alert-warning">' . $this->messages['empty'] . ' ' . $answer . '</p>';
            $this->addSessionData($arr);
        }

    }

    protected function countChar($str, $counter, $answer, $comparison, $arr = []){
        if($comparison === 'max') {

            if (mb_strlen($str) > $counter) {
                $str_res = mb_str_replace('$1', $answer, $this->messages['countMax']);
                $str_res = mb_str_replace('$2', $counter, $str_res);

                $_SESSION['res']['answer'] = '<p class="alert alert-warning">' . $str_res . '</p>';
                $this->addSessionData($arr);
            }

        }elseif($comparison === 'min'){

            if (mb_strlen($str) < $counter) {
                $str_res = mb_str_replace('$1', $answer, $this->messages['countMin']);
                $str_res = mb_str_replace('$2', $counter, $str_res);

                $_SESSION['res']['answer'] = '<p class="alert alert-warning">' . $str_res . '</p>';
                $this->addSessionData($arr);
            }
        }

    }

    protected function Email($email, $answer, $arr = []){

        if($this->model->checkEmail($email)){
            $_SESSION['res']['answer'] = '<p class="alert alert-warning">' . $this->messages['email'] . '</p>';
            $this->addSessionData($arr);
        }

    }

    protected function checkPassword($arr){
        if($arr['pwd'] !== $arr['pwd2']){
            $_SESSION['res']['answer'] = '<p class="alert alert-warning">' . $this->messages['pwd'] . '</p>';
            $this->addSessionData($arr);
        }
    }

    protected function addSessionData($arr = []){

        if(!$arr) $arr = $_POST;

        foreach ($arr as $key => $item){

            $_SESSION['res'][$key] = $item;

        }

        $this->redirect();

    }
}