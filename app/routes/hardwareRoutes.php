<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\HardwareController;
use app\middlewares\AuthMiddleware;

function hardwareRoutes(RouteCollector $router) {
  $router->addGroup('/hardwares', function(RouteCollector $router) {
    $router->addRoute('POST', '', [HardwareController::class, 'create', AuthMiddleware::class, 'handle']);

    $router->addRoute('GET', '/all/related', [HardwareController::class, 'getAllRelatedByUser', AuthMiddleware::class, 'handle']);
    $router->addRoute('GET', '/{hardware_id:\d+}', [HardwareController::class, 'get', AuthMiddleware::class, 'handle']);
    $router->addRoute('GET', '/{hardware_id:\d+}/related', [HardwareController::class, 'getRelated', AuthMiddleware::class, 'handle']);
    $router->addRoute('GET', '/all', [HardwareController::class, 'getAllByUser', AuthMiddleware::class, 'handle']);

    $router->addRoute('PATCH', '/{hardware_id:\d+}/name', [HardwareController::class, 'updateName', AuthMiddleware::class, 'handle']);
    $router->addRoute('PATCH', '/{hardware_id:\d+}/brands', [HardwareController::class, 'updateBrand', AuthMiddleware::class, 'handle']);
    $router->addRoute('PATCH', '/{hardware_id:\d+}/categories', [HardwareController::class, 'updateCategory', AuthMiddleware::class, 'handle']);
    
    $router->addRoute('DELETE', '/{hardware_id:\d+}', [HardwareController::class, 'delete', AuthMiddleware::class, 'handle']);
  });
}
