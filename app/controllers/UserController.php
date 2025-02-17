<?php
namespace app\controllers;

use app\database\models\UsersModel;
use app\database\models\HardwaresModel;
use core\validation\UserValidator;


class UserController {

  public function __construct(
    private UsersModel $userModel,
    private HardwaresModel $hardwareModel,
  ) {}

  public function create(){
    echo "CREATE USER OK";
  }

  public function get($publicUserId){
    echo var_dump( $publicUserId ). " PublicUserId getUser "; 
  }

  public function updateUsername($publicUserId){
    echo $publicUserId . " PublicUserId updateUsername "; 
  }

  public function updatePassword($publicUserId){
    echo $publicUserId . "PublicUserId updatePassword";
  }

  public function delete($publicUserId){
    echo $publicUserId . " PublicUserId DeleteUser "; 
  }
}