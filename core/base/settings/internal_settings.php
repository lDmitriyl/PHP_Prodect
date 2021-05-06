<?php
defined('ACCESS') or die('Access denied');

const TEMPLATE = 'templates/';
const ADMIN_TEMPLATE = 'core/admin/view/';
const UPLOAD_DIR = 'files/';

const PAGINATION = 3;
const DEFAULT_CURRENCY_CODE = 'EUR';


const ADMIN_CSS_JS = [
    'styles' =>['css/bootstrap.min.css', 'css/starter-template.css', 'css/main.css'],
    'scripts' =>['js/bootstrap.js', 'js/jquery.min.js', 'js/tinymce/tinymce.min.js',
        'js/tinymce/tinymce_init.js', 'js/framework.js', 'js/script.js']
];

const USER_CSS_JS = [
    'styles' =>['css/bootstrap.min.css', 'css/starter-template.css', 'css/main.css'],
    'scripts' =>['js/bootstrap.js', 'js/jquery.min.js']
];

use core\base\exceptions\RouteException;

function autoloadMainClasses($class_name){
    $class_name = str_replace('\\','/', $class_name);

    if(!@include_once $class_name . '.php'){
        throw new RouteException('Не верное имя файла для подключения - ' .$class_name);
    }

}

spl_autoload_register('autoloadMainClasses');