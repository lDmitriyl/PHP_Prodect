<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Order extends Model
{
    use Singleton;

    public function getBasketProducts($products){

        $stmt = $this->db->query("SELECT po.id, po.count, po.price, p.name as product_name, p.image FROM product_offers as po
                                    JOIN products as p
                                    ON po.product_id = p.id WHERE po.id IN ($products)");

        return $stmt->fetchAll();
    }

    public function saveOrder($sum, $data, $order){

        $stmt = $this->db->prepare("INSERT INTO orders (`name`, `phone`, `user_id`, `currency_id`, `sum`, `created_at`) VALUES (?,?,?,?,?,?)");

        if($stmt->execute([$data['name'], $data['phone'], $data['user_id'], $data['currency_id'], $sum, date( "Y-m-d H:i:s" )])){

            $orderId = $this->db->lastInsertId();

            $data = $this->dataTieTableWithExtraColumn($order, $orderId , ['order_id', 'product_offer_id', 'countInOrder']);

            if($this->multiInsert($this->db, 'order_product_offer', ['order_id', 'product_offer_id', 'countInOrder'], $data)){

                return true;

            }else{

                return false;
            }

        }else{
            return false;
        }

    }

    public function getOrders($order_id = NULL){

        $order_id ? $where = " WHERE o.id = ?" : $where = "";

        $stmt = $this->db->prepare("SELECT o.id, o.status, o.phone, o.name, o.sum, o.created_at, c.code as currency_code FROM orders as o
                                  JOIN currencies as c 
                                  ON o.currency_id = c.id $where");

        $order_id ? $stmt->execute([$order_id]) : $stmt->execute();

        if($order_id) return $stmt->fetchAll()[0];

        return $stmt->fetchAll();
    }

}