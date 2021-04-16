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

    private $defaultTable = 'user';

    private $validation = [
        'name' => ['empty' => true, 'trim' => true, 'countMax' => 15, 'countMin' => 5, 'str' => true],
        'email' => ['empty' => true, 'trim' => true, 'email' => true, 'str' => true],
        'pwd' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'pwd2' => ['crypt' => true, 'empty' => true,'countMin' => 5],
    ];

    static public function get($property){
        return self::instance()->$property;
    }
}