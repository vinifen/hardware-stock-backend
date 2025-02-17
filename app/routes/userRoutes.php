<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\UserController;
use app\middlewares\AuthMiddleware;

function userRoutes(RouteCollector $router) {

  $router->addRoute('POST', '/users', [UserController::class, 'create']);
  
  $router->addRoute('GET', '/users/{publicUserId}', [UserController::class, 'get', AuthMiddleware::class, 'handle']);

  $router->addRoute('PATCH', '/users/{publicUserId}/username', [UserController::class, 'updateUsername', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/{publicUserId}/password', [UserController::class, 'updatePassword', AuthMiddleware::class, 'handle']);

  $router->addRoute('DELETE', '/users/{publicUserId}', [UserController::class, 'delete', AuthMiddleware::class, 'handle']);

}