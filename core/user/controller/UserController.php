<?php


namespace core\user\controller;


class UserController extends SiteController
{

    public function register(){
        $this->template = 'templates/register';
        $this->execBase();

    }

}