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
            'hrUrl' => false,
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
            ]
        ],
        'settings' => [
            'path' => 'core/base/settings/'
        ],
        'user' => [
            'path' => 'core/user/controller/',
            'hrUrl' => true,
            'routes' => [
                'register' => 'user/register',
                'login' => 'user/login',
                'logout' => 'user/logout',
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
        'name' => ['empty' => true, 'trim' => true, 'countMax' => 15, 'countMin' => 5, 'str' => true],
        'email' => ['empty' => true, 'trim' => true, 'email' => true, 'str' => true],
        'pwd' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'pwd2' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'prodName' => ['empty' => true, 'str' => true],
    ];

    static public function get($property){
        return self::instance()->$property;
    }
}