<?php

namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleControllerRequest.php";

use app\services\AuthService;
use app\services\UserService;
use app\utils\JwtUtils;

class AuthController {
  public function __construct(private AuthService $authService, private UserService $userService) {}

  public function login() {
    handleControllerRequest(function () {
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

  public function requestRefreshToken($userId) {
    echo "Refreshing token for user ID: $userId";
  }

  public function logout($userId) {
    echo "Logging out user ID: $userId";
  }
}
