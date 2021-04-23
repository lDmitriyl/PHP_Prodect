<?php


namespace core\user\model;


use core\base\controller\Singleton;

class PropertyOption extends Model
{
    use Singleton;

    public function getPropertyOption($id = NULL){

        $id ? $where = " WHERE p.id = ?" : $where = "";

        $stmt = $this->db->prepare("SELECT opt.id, opt.name, p.name as property_name FROM property_options as opt
                                    INNER JOIN properties as p ON opt.property_id = p.id $where");

        $id ? $stmt->execute([$id]) : $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getProductOfferOptions($id){

        $stmt = $this->db->prepare("SELECT pp.property_option_id, pp.product_offer_id, p.name, p.id FROM product_offer_property_option as pp
                                    JOIN property_options as p
                                    ON p.id = pp.property_option_id WHERE product_offer_id = ?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function createPropertyOption($data, $messages){

        $stmt = $this->db->prepare("INSERT INTO `property_options` (`name`, `property_id`) VALUES (?, ?)");

        if($stmt->execute([$data['name'], $data['property_id']])){

            $_SESSION['res']['success'] = $messages['createPropertyOptionSuccess'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['createPropertyOptionFail'] . $data['name'];
            return false;
        }
    }

    public function updatePropertyOption($data, $messages){

        $stmt = $this->db->prepare("UPDATE property_options SET name = ? WHERE id = ? ");

        if($stmt->execute([$data['name'], $data['id']])){

            $_SESSION['res']['success'] = $messages['updatePropertyOptionSuccess'] . $data['name'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['updatePropertyOptionFail'] . $data['name'];
            return false;
        }
    }

    public function deletePropertyOption($id, $messages){

        $stmt = $this->db->prepare("DELETE FROM property_options WHERE id = ?");

        if($stmt->execute([$id])){

            $_SESSION['res']['success'] = $messages['deletePropertyOptionSuccess'];
            return true;
        }else{

            $_SESSION['res']['warning'] = $messages['deletePropertyOptionFail'];
            return false;
        }
    }

}