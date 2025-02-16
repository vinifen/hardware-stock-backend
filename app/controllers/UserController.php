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

  public function getUser(){
    try {
      $this->hardwareModel->selectAllRelatedByUserId(2);
      // $this->userModel->selectByUserId(33);
    } catch (\Exception $e) {
      echo $e;
    }
    
  }

  public function createUser(){
    echo "CREATE USER OK";
  }

  public function DeleteUser(){
    echo "DELETE USER OK";
  }
}