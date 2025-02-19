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

      $publicUserId = Uuid::uuid7();
      echo $publicUserId;
      $this->userModel->insert($username, $hashPassword, $publicUserId);

      return "User successfully created with";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(string $publicUserId){
    try {
      $result = $this->userModel->selectUserIdAndUsernameByPublicId($publicUserId);
      if(empty($result)){
        throw new ClientException("User not found");
      }
      echo var_dump($result) . "VARDUM GET" . $publicUserId;
      $userData = $this->userModel->select($result["id"]);
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