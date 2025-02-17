<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\CategoryController;
use app\middlewares\AuthMiddleware;

function categoryRoutes(RouteCollector $router) {
  $router->addRoute("POST", "/categories", [CategoryController::class, "create"]);

  $router->addRoute("GET", "/categories/{categoriesId}", [CategoryController::class, "get", AuthMiddleware::class, "handle"]);
  $router->addRoute("GET", "/categories/all/{userId}", [CategoryController::class, "getAllByUserId", AuthMiddleware::class, "handle"]);

  $router->addRoute("PUT", "/categories/{categoriesId}", [CategoryController::class, "update", AuthMiddleware::class, "handle"]);

  $router->addRoute("DELETE", "/categories/{categoriesId}", [CategoryController::class, "delete", AuthMiddleware::class, "handle"]);
}