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

    function multiInsert($db, $table, $fields, $data){
        $i = 0;

        foreach($data as $d){

            $keys = [];

            foreach($fields as $fn){

                $key = ':' . $i . $fn;
                $keys[] = $key;
                $param[$key] = $d[$fn];
            }

            $stmt_data[] = '('.implode(',',$keys).')';
            $i++;
        }

        $stm_text = 'INSERT INTO '.$table.' ('.implode(',',$fields).') VALUES '.implode(',',$stmt_data);
        $stmt = $db->prepare($stm_text);

        return $stmt->execute($param);
    }

    public function dataTieTable($data, $id, $fieldName){
        $array = [];

        foreach ($data as $item){
            $array[] = [$fieldName[0] => $id, $fieldName[1] => $item];
        }

        return $array;

    }

    public function dataTieTableWithExtraColumn($data, $id, $fieldsName){
        $array = [];
        $i = 0;

        foreach ($data as $item){

            foreach ($fieldsName as $key => $fieldName){

                if($key == 0){
                    $array[$i][$fieldName] = $id;
                    continue;
                }
                if(strpos($fieldName, 'id')) $array[$i][$fieldName] = $item['id'];

                if(array_key_exists($fieldName, $item)) $array[$i][$fieldName] = $item[$fieldName];
            }

            $i ++;
        }
        return  $array;
    }

    public function getFiles($table, $column, $id){

        $column = rtrim(implode(',', $column), ',');

        $stmt = $this->db->prepare("SELECT $column FROM $table WHERE id = ?");
        $stmt->execute([$id]);

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getCountEntity($table){

        $stmt = $this->db->query("SELECT COUNT(*) as count FROM $table");

        return $stmt->fetchAll()[0];

    }

}