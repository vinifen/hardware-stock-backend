<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\HardwareContoller;
use app\middlewares\AuthMiddleware;

function hardwareRoutes(RouteCollector $router) {
  $router->addRoute('POST', '/hardwares', [HardwareContoller::class, 'create']);
  
  $router->addRoute('GET', '/hardwares/{hardwareId}', [HardwareContoller::class, 'get', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/hardwares/related/{hardwareId}', [HardwareContoller::class, 'getRelated', AuthMiddleware::class, 'handle']);

  $router->addRoute('GET', '/hardwares/all/{userId}', [HardwareContoller::class, 'getAllByUserId', AuthMiddleware::class, 'handle']);
  $router->addRoute('GET', '/hardwares/all/related/{userId}', [HardwareContoller::class, 'getAllRelatedByUserId', AuthMiddleware::class, 'handle']);

  $router->addRoute('PATCH', '/hardwares/{hardwareId}', [HardwareContoller::class, 'update']);
  $router->addRoute('PATCH', '/hardwares/{hardwareId}/brands', [HardwareContoller::class, 'updateBrand']);
  $router->addRoute('PATCH', '/hardwares/{hardwareId}/categories', [HardwareContoller::class, 'updateCategory']);

  $router->addRoute('DELETE', '/hardwares/{hardwareId}', [HardwareContoller::class, 'delete']);

}