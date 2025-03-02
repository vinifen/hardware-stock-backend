<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\UserController;
use app\middlewares\AuthMiddleware;

function userRoutes(RouteCollector $router) {

  $router->addRoute('POST', '/users', [UserController::class, 'create']);
  
  $router->addRoute('GET', '/users', [UserController::class, 'get', AuthMiddleware::class, 'handle']);

  $router->addRoute('PATCH', '/users/username', [UserController::class, 'updateUsername', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/password', [UserController::class, 'updatePassword', AuthMiddleware::class, 'handle']);

  $router->addRoute('DELETE', '/users', [UserController::class, 'delete', AuthMiddleware::class, 'handle']);

}