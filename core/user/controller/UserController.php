<?php


namespace core\user\controller;


use core\user\model\User;

class UserController extends SiteController
{

    public function register(){

        $this->template = 'templates/register';

        if($this->isPost()){

            $this->clearPostFields();

            User::instance()->registerNewUser($_POST, $this->messages) ? $this->redirect(PATH) : $this->redirect();
        }
    }

    public function login(){

        $this->template = 'templates/login';

        if($this->isPost()){

            $this->clearPostFields();

            User::instance()->checkLogin($_POST, $this->messages) ? $this->redirect(PATH) : $this->redirect();
        }
    }

    public function logout(){

        if(isset($_SESSION['guest'])){

            unset($_SESSION['guest']);

            setcookie("remember", time() - 3600);

            $this->redirect(PATH);
        }
    }
}