<?php
namespace core\library;

use DI\Container;

use core\library\JwtHandler;

class ContainerDI {
  public static function build(){
    $container = new Container();

    $container->set(JwtHandler::class . "session", function () {
      return new JwtHandler($_ENV["JWT_SESSION_KEY"], time() + (86400 * 7));
    });
    $container->set(JwtHandler::class . "refresh", function () {
      return new JwtHandler($_ENV["JWT_REFRESH_KEY"], time() + (86400 * 2 / 24));
    });

    return $container;
  }
}
