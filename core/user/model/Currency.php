<?php


namespace core\user\model;


use core\base\controller\Singleton;

class Currency extends Model
{
    use Singleton;

    public function getCurrencies(){

        $stmt = $this->db->query("SELECT `id`, `code`, `symbol`, `is_main`, `rate`, `created_at`, `updated_at` FROM currencies");

        return $stmt->fetchAll();
    }

    public function updateCurrency($rate, $id){

        $stmt = $this->db->prepare("UPDATE currencies SET rate = ?, updated_at = ? WHERE id = ?");

        $stmt->execute([$rate, date( "Y-m-d H:i:s" ), $id]);

    }

}