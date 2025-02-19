<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\HardwareContoller;
use app\middlewares\AuthMiddleware;

function hardwareRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/users/{public_user_id}/hardwares', [HardwareContoller::class, 'create', AuthMiddleware::class, 'handle']);
  
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/{hardwareId}', [HardwareContoller::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/{hardwareId}/related', [HardwareContoller::class, 'getRelated', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares', [HardwareContoller::class, 'getAllByUser', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/users/{public_user_id}/hardwares/all/related', [HardwareContoller::class, 'getAllRelatedByUser', AuthMiddleware::class, 'handle']);

  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/name', [HardwareContoller::class, 'updateName', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/brands', [HardwareContoller::class, 'updateBrand', AuthMiddleware::class, 'handle']);
  $router->addRoute('PATCH', '/users/{public_user_id}/hardwares/{hardwareId}/categories', [HardwareContoller::class, 'updateCategory', AuthMiddleware::class, 'handle']);

  $router->addRoute('DELETE', '/users/{public_user_id}/hardwares/{hardwareId}', [HardwareContoller::class, 'delete', AuthMiddleware::class, 'handle']);

  $router->addRoute('GET', '/users/{public_user_id}/hardwares/aggregate/price', [HardwareContoller::class, 'getTotalPrice', AuthMiddleware::class, 'handle']);
}
