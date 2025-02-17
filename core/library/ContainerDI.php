<?php
namespace core\library;


use app\controllers\AuthController;
use app\controllers\BrandController;
use app\controllers\CategoryController;
use app\controllers\UserController;
use app\controllers\HardwareContoller;

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

    $container->set(AuthController::class, \DI\autowire(AuthController::class));
    $container->set(BrandController::class, \DI\autowire(BrandController::class));
    $container->set(CategoryController::class, \DI\autowire(CategoryController::class));
    $container->set(UserController::class, \DI\autowire(UserController::class));
    $container->set(HardwareContoller::class, \DI\autowire(HardwareContoller::class));

    $container->set(DBConnection::class, \DI\autowire(DBConnection::class));

    $container->set(BrandsModel::class, \DI\autowire(BrandsModel::class));
    $container->set(CategoriesModel::class, \DI\autowire(CategoriesModel::class));
    $container->set(HardwaresModel::class, \DI\autowire(HardwaresModel::class));
    $container->set(RefreshTokensModel::class, \DI\autowire(RefreshTokensModel::class));
    $container->set(UsersModel::class, \DI\autowire(UsersModel::class));

    return $container;
  }
}
