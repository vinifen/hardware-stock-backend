<?php
require_once __DIR__ . '/vendor/autoload.php';

use core\Header;
use core\library\DotenvHandler;
use core\library\Router;
use core\library\ContainerDI;
ini_set('error_log',  base_path() . '/php-error.log');

DotenvHandler::loadDotEnv();

Header::apply();
$containerDI = new ContainerDI();
$router = new Router($containerDI->build());
$router->run();









