<?php

namespace app\services;

use Ramsey\Uuid\Uuid;
use app\database\models\UsersModel;
use core\validation\UserValidator;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class UserService {
  public function __construct(private UsersModel $userModel) {}

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
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(string $userId){
    try {
      $userData = $this->userModel->select($userId);
      unset($userDatap["id"]);
      return $userData;
      echo "GET USER SERVICE ok";
    } catch (ClientException $e) {
      throw new ClientException($e->getMessage());
    } catch (InternalException $e){
      throw new InternalException("[Get user]: " . $e->getMessage());
    }
  } 

}