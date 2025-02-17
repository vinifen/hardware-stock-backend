<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\AuthController;
use app\middlewares\AuthMiddleware;

function authRoutes(RouteCollector $router) {
  $router->addRoute("POST", "/auth/login", [AuthController::class, "login"]);

  $router->addRoute("POST", "/auth/{userId}/refresh-token", [AuthController::class, "requestRefreshToken"]);
  $router->addRoute("DELETE", "/auth/{userId}/logout", [AuthController::class, "logout", ]);
}