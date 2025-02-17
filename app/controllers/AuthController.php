<?php

namespace app\controllers;

use app\database\models\RefreshTokensModel;

class AuthController {
  public function __construct(private RefreshTokensModel $refreshTokensModel) {}

  public function login() {
    echo "User login.";
  }

  public function requestRefreshToken($userId) {
    echo "Refreshing token for user ID: $userId";
  }

  public function logout($userId) {
    echo "Logging out user ID: $userId";
  }
}
