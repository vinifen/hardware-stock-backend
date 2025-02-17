<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\BrandController;
use app\middlewares\AuthMiddleware;

function brandRoutes(RouteCollector $router) {
  $router->addRoute("POST", "/brands", [BrandController::class, "create", AuthMiddleware::class, "handle"]);

  $router->addRoute("GET", "/brands/{brandsId}", [BrandController::class, "get", AuthMiddleware::class, "handle"]);
  $router->addRoute("GET", "/brands/all/{userId}", [BrandController::class, "getAllByUserId", AuthMiddleware::class, "handle"]);

  $router->addRoute("PUT", "/brands/{brandsId}", [BrandController::class, "update", AuthMiddleware::class, "handle"]);

  $router->addRoute("DELETE", "/brands/{brandsId}", [BrandController::class, "delete", AuthMiddleware::class, "handle"]);
}