<?php

define('ACCESS', true);

header('Content-Type:text/html;charset=utf-8');
session_start();

//error_reporting(0);

require_once 'config.php';
require_once 'libraries/functions.php';
require_once 'core/base/settings/internal_settings.php';

use core\base\exceptions\RouteException;
use core\base\controller\BaseRoute;
use core\base\exceptions\DbException;

try{
    BaseRoute::routeDirection();
}
catch (RouteException $e) {
    exit($e->getMessage());
}
catch (DbException $e) {
    exit($e->getMessage());
}
