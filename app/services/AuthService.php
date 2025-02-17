<?php
namespace app\services;

use app\database\models\RefreshTokensModel;
use core\library\JwtHandler;
use Psr\Container\ContainerInterface;

class AuthService{
  private $jwtSessionHandler;
  private $jwtRefreshHandler;

  public function __construct(
    private RefreshTokensModel $refreshTokensModel,
    ContainerInterface $container
  ) {
    $this->jwtSessionHandler = $container->get(JwtHandler::class . 'session');
    $this->jwtRefreshHandler = $container->get(JwtHandler::class . 'refresh');
  }

}