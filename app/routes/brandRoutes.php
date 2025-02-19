<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\BrandController;
use app\middlewares\AuthMiddleware;

function brandRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/users/{public_user_id}/brands', [BrandController::class, 'create', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('GET', '/users/{public_user_id}/brands/{brandId}', [BrandController::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/brands/all', [BrandController::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('PUT', '/users/{public_user_id}/brands/{brandId}', [BrandController::class, 'update', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('DELETE', '/users/{public_user_id}/brands/{brandId}', [BrandController::class, 'delete', AuthMiddleware::class, 'handle']);
}
