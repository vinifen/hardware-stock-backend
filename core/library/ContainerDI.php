<?php
namespace core\library;

use app\controllers\UserController;
use DI\Container;
use app\database\DBConnection;

use app\database\models\BrandsModel;
use app\database\models\CategoriesModel;
use app\database\models\HardwaresModel;
use app\database\models\RefreshTokensModel;
use app\database\models\UsersModel;



class ContainerDI {
  public static function build(){
    $container = new Container();

    $container->set(UserController::class, \DI\autowire(UserController::class));

    $container->set(DBConnection::class, \DI\autowire(DBConnection::class));

    $container->set(BrandsModel::class, \DI\autowire(BrandsModel::class));
    $container->set(CategoriesModel::class, \DI\autowire(CategoriesModel::class));
    $container->set(HardwaresModel::class, \DI\autowire(HardwaresModel::class));
    $container->set(RefreshTokensModel::class, \DI\autowire(RefreshTokensModel::class));
    $container->set(UsersModel::class, \DI\autowire(UsersModel::class));

    return $container;
  }
}
