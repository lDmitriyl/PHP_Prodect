<?php


namespace core\admin\controller;


use core\user\model\Order;
use core\user\model\productOffer;

class OrderController extends BaseAdmin
{
      public function index(){

          $this->template = 'core/admin/view/order/index';

          $orders = Order::instance()->getOrders();

          return ['orders' => $orders];

      }

      public function show(){

          $this->template = 'core/admin/view/order/show';

          $order = Order::instance()->getOrders($this->parameters['order_id']);

          $productOffers = ProductOffer::instance()->getProductsFromOrder($this->parameters['order_id']);

          return ['order' => $order, 'productOffers' => $productOffers];

      }
}