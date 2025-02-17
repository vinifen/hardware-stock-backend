<?php
namespace app\middlewares;

use core\library\JwtHandler;
use Psr\Container\ContainerInterface;

class AuthMiddleware {
  private $jwtSessionHandler;
  private $jwtRefreshHandler;

  public function __construct(ContainerInterface $container) {
    $this->jwtSessionHandler = $container->get(JwtHandler::class . 'session');
    $this->jwtRefreshHandler = $container->get(JwtHandler::class . 'refresh');
  }

  private function verifyToken($token, $jwtHandler) {
    if (empty($token)) {
      return false;
    }

    try {
      $jwtHandler->decodeToken($token);
      return true;
    } catch (\Exception $e) {
      error_log($e); // Aqui, você pode melhorar o log dependendo do que deseja registrar
      return false;
    }
  }

  public function handle() {
    $sessionToken = $_COOKIE["sessionToken"] ?? null;
    $refreshToken = $_COOKIE["refreshToken"] ?? null;

    $statusSession = $this->verifyToken($sessionToken, $this->jwtSessionHandler);
    $statusRefresh = $this->verifyToken($refreshToken, $this->jwtRefreshHandler);

    if ($statusRefresh === false) {
      $content = ["stStatus" => $statusSession, "rtStatus" => $statusRefresh];
      send_response(false, $content, 400); // Certifique-se de que 'send_response' está definido corretamente
    }
  }
}
