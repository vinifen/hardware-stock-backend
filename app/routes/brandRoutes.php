<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\BrandController;
use app\middlewares\AuthMiddleware;

function brandRoutes(RouteCollector $router) {
  
  $router->addGroup('/brands', function(RouteCollector $router) {
    $router->addRoute('POST', '', [BrandController::class, 'create', AuthMiddleware::class, 'handle']);

    $router->addRoute('GET', '/{brand_id:\d+}', [BrandController::class, 'get', AuthMiddleware::class, 'handle']);
    $router->addRoute('GET', '/all', [BrandController::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);

    $router->addRoute('PUT', '/{brand_id:\d+}', [BrandController::class, 'update', AuthMiddleware::class, 'handle']);

    $router->addRoute('DELETE', '/{brand_id:\d+}', [BrandController::class, 'delete', AuthMiddleware::class, 'handle']);
  });
}
