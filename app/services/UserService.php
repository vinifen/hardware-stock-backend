<?php

namespace app\services;

use Ramsey\Uuid\Uuid;
use app\database\models\UsersModel;
use core\validation\UserValidator;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class UserService {
  public function __construct(private UsersModel $userModel) {}

  function createUser(string $username, string $password){
    try { 
      UserValidator::username($password);
      $hasUser = $this->userModel->selectUsernameAndUserIdByUsername($username);
      if($hasUser !== null){
        throw new ClientException("User already exists");
      }

      UserValidator::password($username);

      $publicUserId = Uuid::uuid7();
      echo $publicUserId;
      $this->userModel->insert($username, $password, $publicUserId);

      return "User successfully created";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(string $publicUserId){
    try {
      $userId = $this->getUserId($publicUserId);
      $userData = $this->userModel->select($userId);
      echo "GET USER SERVICE ok";
    } catch (ClientException $e) {
      throw new ClientException($e->getMessage());
    } catch (InternalException $e){
      throw new InternalException("[Get user]: " . $e->getMessage());
    }
    
  } 

  public function getUserId(string $publicUserId){
    $userId = $this->userModel->selectUserIdByPublicId($publicUserId);
    return  $userId;  
  }

}