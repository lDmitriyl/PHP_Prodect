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
        'name' => ['empty' => true, 'trim' => true, 'countMax' => 15, 'countMin' => 5],
        'email' => ['empty' => true, 'trim' => true, 'email' => true],
        'pwd' => ['crypt' => true, 'empty' => true,'countMin' => 5],
        'pwd2' => ['crypt' => true, 'empty' => true,'countMin' => 5],
    ];

    static public function get($property){
        return self::instance()->$property;
    }

    public function clueProperties($class){
        $baseProperties = [];

        foreach($this as $name => $item){
            $property = $class::get($name);

            if(is_array($property) && is_array($item)){
                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
                continue;
            }
            if(!$property) $baseProperties[$name] = $this->$name;
        }
        return $baseProperties;
    }

    public function arrayMergeRecursive(){
        $arrays = func_get_args();

        $base = array_shift($arrays);

        foreach ($arrays as $array){
            foreach ($array as $key => $value){
                if(is_array($value) && is_array($base[$key])){
                    $base[$key] = $this->arrayMergeRecursive($base[$key], $value);
                }else{
                    if(is_int($key)){
                        if(!in_array($value, $base)) array_push($base, $value);
                        continue;
                    }
                    $base[$key] = $value;
                }
            }
        }
        return $base;
    }
}