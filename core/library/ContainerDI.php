<?php
namespace core\library;

use app\controllers\UserController;
use DI\Container;
use app\database\models\UserModel;
use core\validation\UsernameVali;

class ContainerDI {
  public static function build(){
    $container = new Container();

    $container->set(UserController::class, \DI\autowire(UserController::class));
    $container->set(UserModel::class, \DI\autowire(UserModel::class));
    $container->set(UsernameVali::class, \DI\autowire(UsernameVali::class));
    return $container;
  }
}
