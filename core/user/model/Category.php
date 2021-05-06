<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Category extends Model
{
    use Singleton;

    public function getCategories($category_id = NULL){

        $category_id ? $where = " WHERE id = ?" : $where = "";

        $stmt = $this->db->prepare("SELECT `id`, `name`, `code`, `description`, `image` FROM categories $where");

        $category_id ? $stmt->execute([$category_id]) : $stmt->execute();

        if($category_id) return $stmt->fetchAll()[0];

        return $stmt->fetchAll();
    }

    public function createCategory($data, $messages, $image = NULL){

        $stmt = $this->db->prepare("INSERT INTO `categories` (`name`, `code`, `description`, `image`) VALUES (?, ?, ?, ?)");

        if($stmt->execute([$data['name'], $data['code'], $data['description'], $image])){

            $_SESSION['res']['success'] = $messages['createCategorySuccess'] . $data['name'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['createCategoryFail'] . $data['name'];
            return false;
        }
    }

    public function updateCategory($data, $messages, $image){

        $stmt = $this->db->prepare("UPDATE categories SET name = ? , code = ?, description = ?, image = ? WHERE id = ? ");

        if($stmt->execute([$data['name'], $data['code'], $data['description'], $image, $data['id']])){

            $_SESSION['res']['success'] = $messages['updateCategorySuccess'] . $data['name'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['updateCategoryFail'] . $data['name'];
            return false;
        }
    }


}