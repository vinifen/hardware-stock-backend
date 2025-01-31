<?php
require_once __DIR__ . '/vendor/autoload.php';

use core\Header;
use core\library\DotenvHandler;
use core\library\Router;

DotenvHandler::loadDotEnv();

Header::apply();

$router = new Router();
$router->run();





