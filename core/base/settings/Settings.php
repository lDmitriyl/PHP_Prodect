<?php


namespace core\base\settings;


use core\base\controller\Singleton;

class Settings
{
    use Singleton;

    private $routes = [
        'admin' => [
            'alias' => 'admin',
            'path' => 'core/admin/controller/',
            'routes' => [
                'products' => 'product/index',
                'product' => 'product/show',
                'add_product' => 'product/create',
                'update_product' => 'product/update',
                'delete_product' => 'product/delete',

                'properties' => 'property/index',
                'property' => 'property/show',
                'add_property' => 'property/create',
                'update_property' => 'property/update',
                'delete_property' => 'property/delete',

                'property_options' => 'propertyOption/index',
                'property_option' => 'propertyOption/show',
                'add_property_option' => 'propertyOption/create',
                'update_property_option' => 'propertyOption/update',
                'delete_property_option' => 'propertyOption/delete',

                'product_offers' => 'productOffer/index',
                'product_offer' => 'productOffer/show',
                'add_product_offer' => 'productOffer/create',
                'update_product_offer' => 'productOffer/update',
                'delete_product_offer' => 'productOffer/delete',
                'delete_images_product_offer' => 'productOffer/deleteImages',

                'orders' => 'order/index',
                'order' => 'order/show',

                'categories' => 'category/index',
                'category' => 'category/show',
                'add_category' => 'category/create',
                'update_category' => 'category/update',
                'delete_category' => 'category/delete',

            ]
        ],
        'settings' => [
            'path' => 'core/base/settings/'
        ],
        'user' => [
            'path' => 'core/user/controller/',
            'routes' => [
                'register' => 'user/register',
                'login' => 'user/login',
                'logout' => 'user/logout',

                'basket' => 'basket/index',
                'add_basket' => 'basket/addBasket',
                'remove_basket' => 'basket/removeBasket',
                'basket_place' => 'basket/basketPlace',
                'basket_confirm' => 'basket/basketConfirm',

                'currency' => 'index/changeCurrency',
            ]
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
        ]
    ];

    private $messages = 'core/base/messages/';

    private $validation = [
        'name' => ['countMax' => 20, 'str' => true],
        'email' => ['empty' => true, 'email' => true, 'str' => true],
        'mail' => ['empty' => true, 'str' => true],
        'password' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'password2' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'prodName' => ['empty' => true, 'str' => true],
        'phone' => ['empty' => true],
        'code' => ['empty' => true],
    ];

    static public function get($property){
        return self::instance()->$property;
    }
}