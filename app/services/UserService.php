<?php

use Ramsey\Uuid\Uuid;
use app\database\models\UsersModel;
use core\validation\UserValidator;

class UserService {
  public function __construct(private UsersModel $userModel) {}

  function createUser(string $username, string $password){
    try {
      $publicUserId = Uuid::uuid7();
      echo $publicUserId;
      UserValidator::password($username);
      UserValidator::username($password);
      $this->userModel->insert($username, $password, $publicUserId);
    } catch (\Exception $e) {
      
    }
  }
}