<?php

namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleController.php";

use app\services\AuthService;
use app\services\UserService;
use app\utils\JwtUtils;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class AuthController {
  public function __construct(private AuthService $authService, private UserService $userService) {}

  public function login() {
    handleController(function () {
      $body = get_body();
      $result = $this->authService->login($body["username"], $body["password"]);
      
      setcookie("token1", $result["sessionToken"], [
        'expires'=>JwtUtils::sessionExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);

      setcookie("token2", $result["refreshToken"], [
        'expires'=>JwtUtils::refreshExpiration(),
        'path'=>'/',
        'secure'=>false,
        'httponly'=>true
      ]);

      send_response(true, ["message"=> "User logged in successfully"], 200);
      
    }, "loggin in");

  }

  public function getNewSession() {
    handleController(function (){ 
      $resultVerify = $this->authService->verifyRefreshToken($_COOKIE["token2"]);

      $newTokens = $this->authService->getNewTokens($resultVerify["user_id"]); 

      $this->authService->removeRefreshToken($_COOKIE["token2"]);
      
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

      send_response(true, ["message"=> "New session obtained"], 200);
    }, "requesting refresh token");

  }

  public function logout() {
    try {
      $this->authService->removeRefreshToken($_COOKIE["token2"]);
      send_response(true, ["message"=> "User logged out successfully"], 200);
    } catch (ClientException $e) {
      error_log($e);
      send_response(false, ["message" => $e->getMessage()], 400); 
    } catch (InternalException $e) {
      error_log($e);
      send_response(false, ["message" => "Internal error on logged out"], 500); 
    } catch (\Exception $e){
      error_log($e);
      send_response(false, ["message" => "Unexpected error on logged out"], 500);
    } finally {
      setcookie("token1", "", time() - 9999 * 100, "/");
      setcookie("token2", "", time() - 9999 * 100, "/");
      exit;
    }
  }
}
