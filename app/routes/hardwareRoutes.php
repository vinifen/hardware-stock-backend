<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\HardwareController;
use app\middlewares\AuthMiddleware;

function hardwareRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/users/{public_user_id}/hardwares', [HardwareController::class, 'create', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/{hardwareId}', [HardwareController::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/{hardwareId}/related', [HardwareController::class, 'getRelated', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares', [HardwareController::class, 'getAllByUser', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/all/related', [HardwareController::class, 'getAllRelatedByUser', AuthMiddleware::class, 'handle']);

  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/name', [HardwareController::class, 'updateName', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/brands', [HardwareController::class, 'updateBrand', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/categories', [HardwareController::class, 'updateCategory', AuthMiddleware::class, 'handle']);

  $router->addRoute('DELETE', '/users/{public_user_id}/hardwares/{hardwareId}', [HardwareController::class, 'delete', AuthMiddleware::class, 'handle']);

  $router->addRoute('GET', '/users/{public_user_id}/hardwares/aggregate/price', [HardwareController::class, 'getTotalPrice', AuthMiddleware::class, 'handle']);
}
