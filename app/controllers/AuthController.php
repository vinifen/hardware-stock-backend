<?php

namespace app\controllers;

use app\services\AuthService;


class AuthController {
  public function __construct(private AuthService $authService) {}

  public function login() {
    echo "AQUI login";
    
    echo "User login.";
  }

  public function requestRefreshToken($userId) {
    echo "Refreshing token for user ID: $userId";
  }

  public function logout($userId) {
    echo "Logging out user ID: $userId";
  }
}
