<?php
namespace app\middlewares;

class AuthMiddleware {
  public function handle() {
    $authenticated = true; 

    if (!$authenticated) {
 
      header('Content-Type: application/json');
      echo json_encode([
        'status' => false,
        'message' => 'Middleware Ok'
      ]);
      exit(); 
    }
    echo json_encode([
      'status' => true,
      'message' => 'Middleware Ok'
    ]);
  }
}
