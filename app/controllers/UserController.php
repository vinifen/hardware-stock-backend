<?php
namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleControllerRequest.php";

use app\services\AuthService;
use app\services\UserService;


class UserController {

  public function __construct(
    private UserService $userService,
    private AuthService $authService
  ) {}

    // ver aqui
  public function create(){
    
    handleControllerRequest(function (){
      $body = get_body();

      $hashPassword = $this->authService->encryptPassword($body["password"]);

      $result = $this->userService->createUser($body["username"], $hashPassword);
      
      send_response(true, ["message" => $result], 200);
    }, "creating user");
  }

  public function get($userId){
    handleControllerRequest(function () use ($userId){
      $userData = $this->userService->get($userId);
      send_response(true, ["message" => "User data successfully obtained" , "data"=>$userData], 200);
    }, "getting user");
  }

  public function updateUsername($userId){
    echo $userId . " PublicUserId updateUsername "; 
  }

  public function updatePassword($userId){
    echo $userId . "PublicUserId updatePassword";
  }

  public function delete($userId){
    echo $userId . " PublicUserId DeleteUser "; 
  }
}