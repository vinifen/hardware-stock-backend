<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\CategoryController;
use app\middlewares\AuthMiddleware;

function categoryRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/categories', [CategoryController::class, 'create', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('GET', '/categories/{category_id:\d+}', [CategoryController::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/categories/all', [CategoryController::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('PUT', '/categories/{category_id:\d+}', [CategoryController::class, 'update', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('DELETE', '/categories/{category_id:\d+}', [CategoryController::class, 'delete', AuthMiddleware::class, 'handle']);
}
