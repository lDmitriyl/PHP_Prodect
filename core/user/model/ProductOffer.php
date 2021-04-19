<?php


namespace core\user\model;


use core\base\controller\Singleton;

class productOffer extends Model
{
    use Singleton;

    public function getProductOffers($id){

        $stmt = $this->db->prepare("SELECT `id`, `count`, `price`, `product_id` FROM product_offers WHERE product_id = ?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function getProductOffer($id){

        $stmt = $this->db->prepare("SELECT pO.id, pO.count, pO.price, pO.product_id, p.name as product_name FROM product_offers as pO
                                    JOIN products as p
                                    ON pO.product_id = p.id WHERE pO.id = ?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function createProductOffer($data, $messages){

        $stmt = $this->db->prepare("INSERT INTO `product_offers` (`product_id`, `count`, `price`) VALUES (?, ?, ?)");

        if($stmt->execute([$data['product_id'], $data['count'], $data['price']])){

            if($_POST['property_id']){

                $id = $this->db->lastInsertId();

                $data = $this->dataTieTable($data['property_id'], $id , ['product_offer_id', 'property_option_id']);

                if($this->multi_insert($this->db, 'product_offer_property_option', ['product_offer_id', 'property_option_id'], $data)){

                    $_SESSION['res']['answer'] = '<p class="alert alert-success">' . $messages['createProductOfferSuccess'] . '</p>';
                    return true;

                }else{

                    $_SESSION['res']['answer'] = '<p class="alert alert-danger">' . $messages['createProductOfferFail'] . '</p>';
                    return false;
                }
            }

            $_SESSION['res']['answer'] = '<p class="alert alert-success">' . $messages['createProductOfferSuccess'] . '</p>';
            return true;
        }

        $_SESSION['res']['answer'] = '<p class="alert alert-danger">' . $messages['createProductOfferFail'] . '</p>';
        return false;
    }

    public function updateProductOffer($data, $messages){

        $stmt = $this->db->prepare("UPDATE product_offers SET `product_id` = ? , `count` = ?, `price` = ? WHERE id = ? ");

        if($stmt->execute([$data['product_id'], $data['price'], $data['count'], $data['id']])){

            $stmt = $this->db->prepare("DELETE FROM product_offer_property_option WHERE product_offer_id = ?");

            $stmt->execute([$data['product_offer_id']]);

            if($data['property_id']){

                $data = $this->dataTieTable($data['property_id'], $data['product_offer_id'] , ['product_offer_id', 'property_option_id']);

                if($this->multi_insert($this->db, 'product_offer_property_option', ['product_offer_id', 'property_option_id'], $data)){

                    $_SESSION['res']['answer'] = '<p class="alert alert-success">' . $messages['updateProductOfferSuccess'] . '</p>';
                    return true;

                }else{

                    $_SESSION['res']['answer'] = '<p class="alert alert-danger">' . $messages['updateProductOfferFail'] . '</p>';
                    return false;
                }
            }

            $_SESSION['res']['answer'] = '<p class="alert alert-success">' . $messages['updateProductOfferSuccess'] . '</p>';
            return true;
        }

        $_SESSION['res']['answer'] = '<p class="alert alert-danger">' . $messages['updateProductOfferFail'] . '</p>';
        return false;
    }

    public function deleteProduct($id, $messages){

        $stmt = $this->db->prepare("DELETE FROM product_offers WHERE id = ?");

        if($stmt->execute([$id])){

            $_SESSION['res']['answer'] = '<p class="alert alert-success">' . $messages['deleteProductOfferSuccess'] . '</p>';
            return true;
        }else{

            $_SESSION['res']['answer'] = '<p class="alert alert-danger">' . $messages['deleteProductOfferFail'] . '</p>';
            return false;
        }
    }


}