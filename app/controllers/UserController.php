<?php
namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleController.php";

use app\services\AuthService;
use app\services\UserService;
use app\utils\JwtUtils;


class UserController {

  public function __construct(
    private UserService $userService,
    private AuthService $authService
  ) {}

  public function create(){
    handleController(function (){
      $body = get_body();

      $hashPassword = $this->authService->encryptPassword($body["password"]);

      $result = $this->userService->createUser($body["username"], $hashPassword);
      
      send_response(true, ["message" => $result], 200);
    }, "creating user.");
  }

  public function get(){
    handleController(function (){
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $userData = $this->userService->getUserData($stPayload->user_id);
      send_response(true, ["message" => "User data successfully obtained." , "data"=>$userData], 200);
    }, "getting user.");
  }

  public function updateUsername(){
    handleController(function (){
      $body = get_body();
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->authService->verifyPassword($body["password"], $stPayload->user_id);

      $this->userService->updateUsername($stPayload->user_id, $body["newUsername"]);

      $this->authService->removeRefreshToken($_COOKIE["token2"]);

      // IDEIA: AQUI ao invez de remover o refresh token pensar em fazer o rt nao carregar informcoes mutaveis como o username, mantendo o refresh token e renovando só o session token 

      $newTokens = $this->authService->getNewTokens($stPayload->user_id);
      
      setcookie("token1", $newTokens["sessionToken"], [
        'expires'=>JwtUtils::sessionExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);

      setcookie("token2", $newTokens["refreshToken"], [
        'expires'=>JwtUtils::refreshExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);

      send_response(true, ["message" => "Username successfully updated."], 200);
    }, "updating username.");
  }

  public function updatePassword(){
    handleController(function () {
      $body = get_body();
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->authService->verifyPassword($body["password"], $stPayload->user_id);

      $hashPassword = $this->authService->encryptPassword($body["password"]);
      $this->userService->updatePassword($stPayload->user_id, $hashPassword);

      $newTokens = $this->authService->getNewTokens($stPayload->user_id);

      setcookie("token1", $newTokens["sessionToken"], [
        'expires'=>JwtUtils::sessionExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);

      setcookie("token2", $newTokens["refreshToken"], [
        'expires'=>JwtUtils::refreshExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);
      
      send_response(true, ["message" => "Password successfully updated."], 200);
    }, "updating password.");
  }

  public function delete(){
    handleController(function (){
      $body = get_body();
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      
      $this->authService->verifyPassword($body["password"], $stPayload->user_id);

      $this->userService->userModel->delete($stPayload->user_id);

      setcookie("token1", "", time() - 9999 * 100, "/");
      setcookie("token2", "", time() - 9999 * 100, "/");

      send_response(true, ["message" => "User successfully deleted."], 200);
    }, "deleting user.");
  }
}