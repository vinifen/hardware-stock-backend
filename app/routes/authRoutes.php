<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\AuthController;

function authRoutes(RouteCollector $router) {

  $router->addGroup('/auth', function(RouteCollector $router) {
    $router->addRoute('POST', '/login', [AuthController::class, 'login']);
    $router->addRoute('POST', '/refresh-session', [AuthController::class, 'getNewSession']);
    
    $router->addRoute('DELETE', '/logout', [AuthController::class, 'logout']);
  });
}
