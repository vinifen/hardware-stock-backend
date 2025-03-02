<?php
namespace app\routes;

use FastRoute\RouteCollector;
use app\controllers\AuthController;

function authRoutes(RouteCollector $router) {
  $router->addRoute("POST", "/auth/login", [AuthController::class, "login"]);

  $router->addRoute("POST", "/auth/refresh-session", [AuthController::class, "getNewSession"]);
  $router->addRoute("DELETE", "/auth/logout", [AuthController::class, "logout", ]);
}