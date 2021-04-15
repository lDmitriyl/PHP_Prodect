<?php


namespace core\user\controller;


use core\user\model\User;

class UserController extends SiteController
{

    public function register(){
        $user = User::instance();
        $this->template = 'templates/register';

        if($this->isPost()){
            if(!empty($_POST['_token'] && $this->tokensMatch($_POST['_token']))){
                $this->clearPostFields();
                $user->registerNewUser($_POST, $this->messages) ? $this->redirect(PATH) : $this->redirect();
            }
        }
    }

    public function login(){
        $user = User::instance();
        $this->template = 'templates/login';

        if($this->isPost()){
            if(!empty($_POST['_token'] && $this->tokensMatch($_POST['_token']))) {
                $this->clearPostFields();
                $user->checkLogin($_POST, $this->messages) ? $this->redirect(PATH) : $this->redirect();
            }
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