<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\UserController;
use app\middlewares\AuthMiddleware;

function userRoutes(RouteCollector $router) {

  $router->addGroup('/users', function(RouteCollector $router) {
    $router->addRoute('POST', '', [UserController::class, 'create']);

    $router->addRoute('GET', '', [UserController::class, 'get', AuthMiddleware::class, 'handle']);

    $router->addRoute('PATCH', '/username', [UserController::class, 'updateUsername', AuthMiddleware::class, 'handle']); 
    $router->addRoute('PATCH', '/password', [UserController::class, 'updatePassword', AuthMiddleware::class, 'handle']);
    
    $router->addRoute('DELETE', '', [UserController::class, 'delete', AuthMiddleware::class, 'handle']);
  });
}
