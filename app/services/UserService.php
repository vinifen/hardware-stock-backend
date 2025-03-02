<?php

namespace app\services;

use Ramsey\Uuid\Uuid;
use app\database\models\UsersModel;
use core\validation\UserValidator;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class UserService {
  public function __construct(public UsersModel $userModel) {}

  function createUser(string $username, string $hashPassword){
    try { 
      UserValidator::username($username);
      $hasUser = $this->userModel->selectUsernameAndUserIdByUsername($username);
      if($hasUser !== null){
        throw new ClientException("User already exists");
      }

      $userId = Uuid::uuid7();
      echo $userId;
      $this->userModel->insert($username, $hashPassword, $userId);

      return "User successfully created with";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getUserData(string $userId){
    try {
      $userData = $this->userModel->select($userId);
      if(empty($userData)){
        throw new ClientException("User not found");
      }
      return $userData;
      echo "GET USER SERVICE ok";
    } catch (\Exception $e){
      throw $e;
    }
  } 

  public function updateUsername(string $userId, string $newUsername){
    try {
      UserValidator::username($newUsername);
      $this->userModel->alterUsername($userId, $newUsername);
      return "Username successfully updated";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updatePassword(string $userId, string $newPassword){
    try {
      UserValidator::password($newPassword);
      $this->userModel->alterPassword($userId, $newPassword);
      return "Password successfully updated";
    } catch (\Exception $e){
      throw $e;
    }
  }

}