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
use app\middlewares\AuthMiddleware;

use app\services\HardwareService;
use app\services\UserService;
use app\services\AuthService;
use app\services\BrandService;
use app\services\CategoryService;
use core\library\JwtHandler;

class ContainerDI {
  public static function build(){
    $container = new Container();

    $container->set(UserService::class, \DI\autowire(UserService::class));
    $container->set(AuthService::class, \DI\autowire(AuthService::class));
    $container->set(HardwareService::class, \DI\autowire(HardwareService::class));
    $container->set(CategoryService::class, \DI\autowire(CategoryService::class));
    $container->set(BrandService::class, \DI\autowire(BrandService::class));

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

    $container->set(AuthMiddleware::class, \DI\autowire(AuthMiddleware::class));

    $container->set(JwtHandler::class . "session", function () {
      return new JwtHandler($_ENV["JWT_SESSION_KEY"], time() + (86400 * 7));
    });
    $container->set(JwtHandler::class . "refresh", function () {
      return new JwtHandler($_ENV["JWT_REFRESH_KEY"], time() + (86400 * 2 / 24));
    });

    return $container;
  }
}
