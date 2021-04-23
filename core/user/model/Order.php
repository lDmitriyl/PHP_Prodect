<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Order extends Model
{
    use Singleton;

    public function getOrder($products){

        $stmt = $this->db->query("SELECT po.id, po.count, po.price, p.name as product_name, p.image FROM product_offers as po
                                    JOIN products as p
                                    ON po.product_id = p.id WHERE po.id IN ($products)");

        return $stmt->fetchAll();
    }

    public function saveOrder($sum, $data, $order){

        $stmt = $this->db->prepare("INSERT INTO orders (`name`, `phone`, `user_id`, `sum`) VALUES (?,?,?,?)");

        if($stmt->execute([$data['name'], $data['phone'], $data['user_id'], $sum])){

            $orderId = $this->db->lastInsertId();

            $data = $this->dataTieTableWithExtraColumn($order, $orderId , ['order_id', 'product_offer_id', 'countInOrder']);

            if($this->multi_insert($this->db, 'order_product_offer', ['order_id', 'product_offer_id', 'countInOrder'], $data)){

                return true;

            }else{

                return false;
            }

        }else{
            return false;
        }

    }

}