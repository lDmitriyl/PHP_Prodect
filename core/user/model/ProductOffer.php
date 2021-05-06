<?php


namespace core\user\model;


use core\base\controller\Singleton;
use PDO;
class productOffer extends Model
{
    use Singleton;

    public function getProductOffers($product_id = NULL, $arrLimit = []){

        $product_id ? $where = " WHERE po.product_id = :id " : $where = "";
        !empty($arrLimit) ? $limit = "LIMIT :lim1 , :lim2 " : $limit = '';

        $stmt = $this->db->prepare("SELECT po.id, po.count, po.price, po.gallery_img, po.image, p.name as product_name FROM product_offers as po
                                    JOIN products as p 
                                    ON po.product_id = p.id $where$limit");

        if($product_id) $stmt->bindValue(":id", $product_id, PDO::PARAM_INT);

        if(!empty($arrLimit)) {
            $stmt->bindValue(":lim1", $arrLimit[0], PDO::PARAM_INT);
            $stmt->bindValue(":lim2", $arrLimit[1], PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getProductOffer($id){

        $stmt = $this->db->prepare("SELECT pO.id, pO.count, pO.price, pO.product_id, pO.gallery_img, pO.image, p.name as product_name
                                    FROM product_offers as pO
                                    JOIN products as p
                                    ON pO.product_id = p.id WHERE pO.id = ?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function createProductOffer($data, $file, $messages){

        $stmt = $this->db->prepare("INSERT INTO `product_offers` (`product_id`, `count`, `price`, `gallery_img`, `image`) VALUES (?, ?, ?, ?, ?)");

        if($stmt->execute([$data['product_id'], $data['count'], $data['price'], $file['gallery_img'], $file['image']])){

            if($_POST['property_id']){

                $id = $this->db->lastInsertId();

                $data = $this->dataTieTable($data['property_id'], $id , ['product_offer_id', 'property_option_id']);

                if($this->multiInsert($this->db, 'product_offer_property_option', ['product_offer_id', 'property_option_id'], $data)){

                    $_SESSION['res']['success'] = $messages['createProductOfferSuccess'];
                    return true;

                }else{

                    $_SESSION['res']['warning'] = $messages['createProductOfferFail'];
                    return false;
                }
            }

            $_SESSION['res']['success'] = $messages['createProductOfferSuccess'];
            return true;
        }

        $_SESSION['res']['warning'] = $messages['createProductOfferFail'];
        return false;
    }

    public function updateProductOffer($data, $file, $messages){


        if($file){
            $file['image'] ? $query = "UPDATE product_offers SET `product_id` = ? , `count` = ?, `price` = ?, `gallery_img` = ?, `image` = ? WHERE id = ?" :
                $query = "UPDATE product_offers SET `product_id` = ? , `count` = ?, `price` = ?, `gallery_img` = ? WHERE id = ?";
        }else{
            $query = "UPDATE product_offers SET `product_id` = ? , `count` = ?, `price` = ? WHERE id = ?";
        }

        $stmt = $this->db->prepare($query);

        if($file){
            $file['image'] ? $res = $stmt->execute([$data['product_id'], $data['price'], $data['count'], $file['gallery_img'], $file['image'], $data['id']]) :
                $res = $stmt->execute([$data['product_id'], $data['price'], $data['count'], $file['gallery_img'], $data['id']]);
        }else{
            $res = $stmt->execute([$data['product_id'], $data['price'], $data['count'], $data['id']]);
        }


        if($res){

            $stmt = $this->db->prepare("DELETE FROM product_offer_property_option WHERE product_offer_id = ?");

            $stmt->execute([$data['product_offer_id']]);

            if($data['property_id']){

                $data = $this->dataTieTable($data['property_id'], $data['product_offer_id'] , ['product_offer_id', 'property_option_id']);

                if($this->multiInsert($this->db, 'product_offer_property_option', ['product_offer_id', 'property_option_id'], $data)){

                    $_SESSION['res']['success'] = $messages['updateProductOfferSuccess'];
                    return true;

                }else{

                    $_SESSION['res']['warning'] = $messages['updateProductOfferFail'];
                    return false;
                }
            }

            $_SESSION['res']['success'] = $messages['updateProductOfferSuccess'];
            return true;
        }

        $_SESSION['res']['warning'] = $messages['updateProductOfferFail'];
        return false;
    }

    public function deleteProduct($id, $messages){

        $stmt = $this->db->prepare("DELETE FROM product_offers WHERE id = ?");

        if($stmt->execute([$id])){

            $_SESSION['res']['success'] = $messages['deleteProductOfferSuccess'];
            return true;
        }else{

            $_SESSION['res']['warning'] = $messages['deleteProductOfferFail'];
            return false;
        }
    }

    public function updatePOCount($data){

        foreach ($data as $product){

            $count = $product['count'] - $product['countInOrder'];

            $stmt = $this->db->prepare('UPDATE product_offers SET count = ? WHERE id = ?');

            if(!$stmt->execute([$count, $product['id']]))

                return false;

        }

        return true;
    }

    public function getProductsFromOrder($order_id){

        $stmt = $this->db->prepare("SELECT p.id as product_id, p.name, po.image, po.id, po.price, op.countInOrder FROM products as p
                                    JOIN product_offers as po
                                    ON p.id = po.product_id 
                                    JOIN order_product_offer as op 
                                    ON po.id = op.product_offer_id WHERE op.order_id = ?");

        $stmt->execute([$order_id]);

        return $stmt->fetchAll();

    }

    public function updateImage($table , $column, $data, $id){

        $stmt = $this->db->prepare("UPDATE $table SET $column = ? WHERE id = ?");

        return $stmt->execute([$data, $id]);

    }


}