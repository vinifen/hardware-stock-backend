<?php
require_once __DIR__ . '/vendor/autoload.php';

use core\Header;
use core\library\DotenvHandler;
use core\library\Router;
use app\database\DBConnection;
use core\library\ContainerDI;

DotenvHandler::loadDotEnv();

Header::apply();
$containerDI = new ContainerDI();
$router = new Router($containerDI->build());
$router->run();








