<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\AuthController;
use app\middlewares\AuthMiddleware;

function authRoutes(RouteCollector $router) {
  $router->addRoute("POST", "/auth/login", [AuthController::class, "login"]);

  $router->addRoute("POST", "/auth/refresh-token", [AuthController::class, "getNewSession"]);
  $router->addRoute("DELETE", "/auth/logout", [AuthController::class, "logout", ]);
}