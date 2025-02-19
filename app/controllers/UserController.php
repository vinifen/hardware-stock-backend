<?php
namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleControllerRequest.php";

use app\database\models\UsersModel;
use app\database\models\HardwaresModel;
use app\services\AuthService;
use core\validation\UserValidator;
use app\services\UserService;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class UserController {

  public function __construct(
    private UserService $userService,
    private AuthService $authService
  ) {}


  public function create(){
    
    handleControllerRequest(function (){
      $body = get_body();

      $hashPassword = $this->authService->encryptPassword($body["password"]);

      $result = $this->userService->createUser($body["username"], $hashPassword);
      
      send_response(true, ["message" => $result], 200);
    }, "creating user");
  }

  public function get($publicUserId){
    handleControllerRequest(function () use ($publicUserId){
      $body = get_body();
      $userData = $this->userService->get($publicUserId);
      send_response(true, ["message" => "User data successfully obtained" , "data"=>$userData], 200);
    }, "getting user");
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