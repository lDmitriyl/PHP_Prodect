<?php


namespace core\user\model;

use core\base\controller\Singleton;

class User extends Model
{
    use Singleton;

    public function registerNewUser($data, $messages)
    {
        $stmt = $this->db->prepare('INSERT INTO `users` (`name`, `email`, `password`) VALUES (?, ?, ?)');

        if ($stmt->execute([$data['name'], $data['email'], $data['password']])) {

            $stmt = $this->db->prepare('SELECT `id`, `name`, `email` FROM users WHERE email = ?');

            $stmt->execute([$data['email']]);
            $result = $stmt->fetchAll();

            if(isset($result[0])){

                $_SESSION['res']['success'] = $messages['registerSuccess'];
                $_SESSION['guest'] = $result[0];
                return true;

            }else{
                $_SESSION['res']['warning'] = $messages['registerFail'];
            }

        }else {
            $_SESSION['res']['warning'] = $messages['registerFail'];
        }
        return false;
    }

    public function checkLogin($data, $messages){

        $stmt = $this->db->prepare('SELECT `id`, `name`, `email` FROM users WHERE email = ? and password = ?');

        $stmt->execute([$data['mail'], $data['password']]);
        $result = $stmt->fetchAll();

        if(isset($result[0])){

            if($data['remember']) {

                $result['remember_token'] = md5($result[0]['id'] . time());
                $stmt = $this->db->prepare('UPDATE `users` SET `remember_token`= ? WHERE `email`= ?');

                if($stmt->execute([$data['mail'], $result['remember_token']])){

                    if($result['remember_token'] && $result['remember_token'] !== NULl){
                        setcookie("remember", $result['remember_token'], time() + (1000 * 60 * 60 * 24 * 30));
                    }
                }
            }

            setcookie("remember", time() - 3600);

            $_SESSION['res']['success'] = $messages['loginSuccess'];
            $_SESSION['guest'] = $result[0]['name'] ? $result[0]['name'] : $result[0]['email'];
            return true;

        }else{
            $_SESSION['res']['warning'] = $messages['loginFail'];
        }
        return false;
    }

    public function getUser($token){

        $stmt = $this->db->prepare('SELECT `name`, `email` FROM users WHERE remember_token = ?');

        $stmt->execute([$token]);

        return $stmt->fetchAll();
    }

}