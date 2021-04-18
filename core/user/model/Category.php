<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Category extends Model
{
    use Singleton;

    public function getCategories(){

        $stmt = $this->db->query("SELECT `id`, `name`, `code`, `description`, `image` FROM categories");

        return $stmt->fetchAll();
    }
}