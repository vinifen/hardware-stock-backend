<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\CategoryController;
use app\middlewares\AuthMiddleware;

function categoryRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/users/{public_user_id}/categories', [CategoryController::class, 'create', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('GET', '/users/{public_user_id}/categories/{categoryId}', [CategoryController::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/categories/all', [CategoryController::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('PUT', '/users/{public_user_id}/categories/{categoryId}', [CategoryController::class, 'update', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('DELETE', '/users/{public_user_id}/categories/{categoryId}', [CategoryController::class, 'delete', AuthMiddleware::class, 'handle']);
}
