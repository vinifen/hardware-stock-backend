<?php
namespace core\library;

require_once base_path() . '/app/routes/authRoutes.php';
require_once base_path() . '/app/routes/userRoutes.php';
require_once base_path() . '/app/routes/brandRoutes.php';
require_once base_path() . '/app/routes/categoryRoutes.php';
require_once base_path() . '/app/routes/hardwareRoutes.php';

use FastRoute;
use FastRoute\RouteCollector;
use DI\Container;

use app\routes;


class Router { 

  public function __construct(private Container $container) {}

  public function run() {
    $dispatcher = FastRoute\simpleDispatcher(
      function (RouteCollector $route) {
        routes\authRoutes($route);
        routes\userRoutes($route);
        routes\brandRoutes($route);
        routes\categoryRoutes($route);
        routes\hardwareRoutes($route);
      }
    );
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    $routeInfo = $dispatcher->dispatch($method, $uri);

    switch ($routeInfo[0]){
      case FastRoute\Dispatcher::NOT_FOUND;
        send_response(false, ["message"=>"Route not found"], 404);
        break;
      case FastRoute\Dispatcher::METHOD_NOT_ALLOWED;
        send_response(false, ["message"=>"Method not allowed"], 405);
        break;
      case FastRoute\Dispatcher::FOUND;
        $controller = $routeInfo[1][0];
        $functionController = $routeInfo[1][1];

        $middleware = $routeInfo[1][2] ?? null;
        $functionMiddleware = $routeInfo[1][3] ?? null;

        $params = array_values($routeInfo[2]);

        if($middleware){
          $newMiddleware = $this->container->get($middleware);
          call_user_func_array([$newMiddleware, $functionMiddleware], $params);
        }
  
        $newController = $this->container->get($controller);
        call_user_func_array([$newController, $functionController], $params);
        break;
    }
  }
}