<?php


namespace core\base\model;

use core\base\exceptions\DbException;
use PDO;
use PDOException;

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
        try {
            $this->db = new PDO($dsn, $user, $password, $opt);
        }catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
    }

    public function getFiles($table, $column, $id){

        $stmt = $this->db->prepare("SELECT $column FROM $table WHERE id = ?");
        $stmt->execute([$id]);

        $result = $stmt->fetchAll();

        return $result;
    }

}