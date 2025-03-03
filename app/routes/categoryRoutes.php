<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\CategoryController;
use app\middlewares\AuthMiddleware;

function categoryRoutes(RouteCollector $router) {

  $router->addGroup('/categories', function(RouteCollector $router) {
    $router->addRoute('POST', '', [CategoryController::class, 'create', AuthMiddleware::class, 'handle']);

    $router->addRoute('GET', '/{category_id:\d+}', [CategoryController::class, 'get', AuthMiddleware::class, 'handle']);
    $router->addRoute('GET', '/all', [CategoryController::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);

    $router->addRoute('PUT', '/{category_id:\d+}', [CategoryController::class, 'update', AuthMiddleware::class, 'handle']);
    
    $router->addRoute('DELETE', '/{category_id:\d+}', [CategoryController::class, 'delete', AuthMiddleware::class, 'handle']);
  });
}
