<?php


namespace core\base\model;

use core\base\exceptions\DbException;
use PDO;
abstract class BaseModel
{

    protected $db;

    protected function connect(){

        $opt = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES   => false);
        $host = HOST;
        $dbname = DB_NAME;
        $user= USER;
        $password = PASS;
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $this->db =  new PDO($dsn,$user,$password,$opt);

    }

}