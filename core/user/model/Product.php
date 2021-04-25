<?php


namespace core\user\model;


use core\base\controller\Singleton;
use core\base\model\BaseModel;

class Product extends BaseModel
{
    use Singleton;

    public function getProduct($id = NULL){

        $id ? $where = " WHERE p.id = ?" : $where = "";

        $stmt = $this->db->prepare("SELECT p.id, p.name, p.code, p.description, p.image, c.name as category_name FROM products as p
        INNER JOIN categories as c ON  p.category_id = c.id $where");

        $id ? $stmt->execute([$id]) : $stmt->execute();

        return $stmt->fetchAll();
    }

    public function createProduct($data, $messages, $image = NULL){

        $stmt = $this->db->prepare("INSERT INTO `products` (`name`, `code`, `description`, `category_id`, `image`) VALUES (?, ?, ?, ?, ?)");

        if($stmt->execute([$data['prodName'], $data['code'], $data['description'], $data['category_id'], $image])){

            if($data['property_id']){

                $product_id = $this->db->lastInsertId();

                $data = $this->dataTieTable($data['property_id'], $product_id , ['product_id', 'property_id']);

                if($this->multiInsert($this->db, 'property_product', ['product_id', 'property_id'], $data)){

                    $_SESSION['res']['success'] = $messages['createProductSuccess'] . $data['prodName'];
                    return true;

                }else{

                    $_SESSION['res']['warning'] = $messages['createProductFail'] . $data['prodName'];
                    return false;
                }
            }

            $_SESSION['res']['success'] = $messages['createProductSuccess'] . $data['prodName'];
            return true;
        }

        $_SESSION['res']['warning'] = $messages['createProductFail'] . $data['prodName'];
        return false;
    }

    public function updateProduct($data, $messages, $image = NULL){

        $stmt = $this->db->prepare("UPDATE products SET `name` = ? , `code` = ?, `description` = ?, `category_id` = ?, `image` = ? WHERE id = ? ");

        if($stmt->execute([$data['prodName'], $data['code'], $data['description'], $data['category_id'], $image, $data['id']])){

            $stmt = $this->db->prepare("DELETE FROM property_product WHERE product_id = ?");

            $stmt->execute([$data['id']]);

            if($data['property_id']){

                $data = $this->dataTieTable($data['property_id'], $data['id'] , ['product_id', 'property_id']);

                if($this->multiInsert($this->db, 'property_product', ['product_id', 'property_id'], $data)){

                    $_SESSION['res']['success'] = $messages['updateProductSuccess'] . $data['prodName'];
                    return true;

                }else{

                    $_SESSION['res']['warning'] = $messages['updateProductFail'] . $data['prodName'];
                    return false;
                }
            }

            $_SESSION['res']['success'] = $messages['updateProductSuccess'] . $data['prodName'];
            return true;
        }

        $_SESSION['res']['warning'] = $messages['updateProductFail'] . $data['prodName'];
        return false;
    }

    public function deleteProduct($id, $messages){

        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");

        if($stmt->execute([$id])){

            $_SESSION['res']['success'] = $messages['deleteProductSuccess'];
            return true;
        }else{

            $_SESSION['res']['warning'] = $messages['deleteProductFail'];
            return false;
        }
    }

}