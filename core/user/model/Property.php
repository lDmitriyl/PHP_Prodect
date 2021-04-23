<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Property extends Model
{
    use Singleton;

    public function getProperty(){

        $stmt = $this->db->query("SELECT `id`, `name` FROM properties");

        return $stmt->fetchAll();
    }

    public function getProductProperties($id){

        $stmt = $this->db->prepare("SELECT pp.property_id, pp.product_id, p.name, p.id FROM property_product as pp JOIN properties as p
                                    ON p.id = pp.property_id WHERE product_id = ?");

        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function getPropertyWithOptions($data){
        $arr = [];

        if($data){

            foreach ($data as $property){
                $stmt = $this->db->prepare( "SELECT id, name, property_id FROM property_options WHERE property_id = ?");

                $stmt->execute([$property['property_id']]);

                $arr[$property['name']] = $stmt->fetchAll();
            }

        }

        return $arr;
    }

    public function createProperty($data, $messages){

        $stmt = $this->db->prepare("INSERT INTO `properties` (`name`) VALUES (?)");

        if($stmt->execute([$data['name']])){

            $_SESSION['res']['success'] = $messages['createPropertySuccess'] . $data['name'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['createPropertyFail'] . $data['name'];
            return false;
        }
    }

    public function updateProperty($data, $messages){

        $stmt = $this->db->prepare("UPDATE properties SET name = ? WHERE id = ? ");

        if($stmt->execute([$data['name'], $data['id']])){

            $_SESSION['res']['success'] = $messages['updatePropertySuccess'] . $data['name'];
            return true;

        }else{

            $_SESSION['res']['warning'] = $messages['updatePropertyFail'] . $data['name'];
            return false;
        }
    }

    public function deleteProperty($id, $messages){

        $stmt = $this->db->prepare("DELETE FROM properties WHERE id = ?");

        if($stmt->execute([$id])){

            $_SESSION['res']['success'] = $messages['deletePropertySuccess'];
            return true;
        }else{

            $_SESSION['res']['warning'] = $messages['deletePropertyFail'];
            return false;
        }
    }

}