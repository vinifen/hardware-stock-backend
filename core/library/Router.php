<?php
namespace core\library;
require_once __DIR__ . '/../../app/routes/userRoutes.php';

use app\routes; 
use FastRoute;
use FastRoute\RouteCollector;
use DI\Container;

class Router{ 

  public function __construct(private Container $container) {}

  public function run(){
    $dispatcher = FastRoute\simpleDispatcher(
      function (RouteCollector $route){
        routes\userRoutes($route);
      }
    );

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    $routeInfo = $dispatcher->dispatch($method, $uri);

    print_r($routeInfo);
    switch ($routeInfo[0]){
      case FastRoute\Dispatcher::NOT_FOUND;
        echo "404 Not Found";
        break;
      case FastRoute\Dispatcher::METHOD_NOT_ALLOWED;
        echo "405 Method Not Allowed";
        break;
      case FastRoute\Dispatcher::FOUND;
        $controller = $routeInfo[1][0];
        $functionController = $routeInfo[1][1];

        $middleware = $routeInfo[1][2];
        $functionMiddleware = $routeInfo[1][3];

        $params = $routeInfo[2];

        if($middleware){
          echo "Middleware existe";
          $newMiddleware = new $middleware();
          call_user_func_array([$newMiddleware, $functionMiddleware], $params);
        }
  
        $newController = $this->container->get($controller);
        call_user_func_array([$newController, $functionController], $params);
        break;
    }
  }
}