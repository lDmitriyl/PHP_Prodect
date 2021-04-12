<?php


namespace core\user\controller;


use core\base\controller\BaseController;
use core\base\settings\Settings;
use core\user\model\Model;

abstract class SiteController extends BaseController
{
    protected $model;

    protected $menu;
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
}