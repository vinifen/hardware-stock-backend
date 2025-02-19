<?php
namespace app\middlewares;

use core\library\JwtHandler;
use Psr\Container\ContainerInterface;

class AuthMiddleware {
  private $jwtSessionHandler;
  private $jwtRefreshHandler;

  public function __construct(
    ContainerInterface $container
  ) {
    $this->jwtSessionHandler = $container->get(JwtHandler::class . 'session');
    $this->jwtRefreshHandler = $container->get(JwtHandler::class . 'refresh');
  }

  public function handle() {

    $statusSession = null;
    $sessionToken = $_COOKIE["token1"];
    echo var_dump($sessionToken) . "AQUI COOKIE";
    if(!empty($sessionToken)){
      try {
        $this->jwtSessionHandler->decodeToken($sessionToken);
        $statusSession = true;
      } catch (\Exception $e) {
        error_log($e);
        $statusSession = false;
      }  
    }else{
      $statusSession = false;
    }

    $statusRefresh = null;
    $refreshToken = $_COOKIE["token2"];
    if(!empty($refreshToken)){
      try {
        $this->jwtRefreshHandler->decodeToken($refreshToken);
        $statusRefresh = true;
      } catch (\Exception $e) {
        error_log($e);
        $statusRefresh = false;
      }  
    }else{
      $statusRefresh = false;
    }

    if($statusSession === false){
      $content = ["stStatus" => $statusSession, "rtStatus" => $statusRefresh, ];
      send_response(false, $content, 400);
    }

  }
}