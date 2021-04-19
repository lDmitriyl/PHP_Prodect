<?php

namespace core\user\model;

use core\base\controller\Singleton;
use core\base\model\BaseModel;

class Model extends BaseModel
{
    use Singleton;

    public function checkEmail($email){

        $stmt = $this->db->prepare('SELECT `email` FROM `users` WHERE email = ? LIMIT 1');

        $stmt->execute([$email]);

        if($stmt->fetchAll()){
            return true;
        }else{
            return false;
        }
    }

}