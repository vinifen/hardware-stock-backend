<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\UserController;
use app\middlewares\AuthMiddleware;

function userRoutes(RouteCollector $router) {
  
  $router->addRoute('GET', '/users', [UserController::class, 'getUser', AuthMiddleware::class, 'handle']);

  $router->addRoute('POST', '/users', [UserController::class, 'createUser']);

  $router->addRoute('DELETE', '/users', [UserController::class, 'deleteUser']);

}