<?php
namespace app\controllers;

use app\database\models\UserModel;
use core\validation\UsernameVali;

class UserController {
  public function __construct(
    private UserModel $userModel,
    private UsernameVali $usernameVali
  ) {}

  public function getUser(){
    $this->userModel->exec();
    echo $this->usernameVali->get();
    echo "GET USER OK";
  }

  public function createUser(){
    echo "CREATE USER OK";
  }

  public function DeleteUser(){
    echo "DELETE USER OK";
  }
}