<?php
namespace app\middlewares;

use app\services\AuthService;

class AuthMiddleware {

  public function __construct(
    private AuthService $authService,
  ) {}

  public function handle() {
    $statusSession = null;
    $sessionToken = $_COOKIE["token1"];
    
    if(!empty($sessionToken)){
      try {
        $this->authService->jwtSessionHandler->decodeToken($sessionToken);
        $statusSession = true;
      } catch (\Exception $e) {
        error_log($e);
        $statusSession = false;
      }  
    }else{
      $statusSession = false;
    }

    $statusRefresh = null;
    $refreshToken = $_COOKIE["token2"];
    // if(!empty($refreshToken)){
    //   try {
    //     $this->authService->verifyRefreshToken($refreshToken);
    //     $statusRefresh = true;
    //   } catch (\Exception $e) {
    //     error_log($e);
    //     $statusRefresh = false;
    //   }  
    // }else{
    //   $statusRefresh = false;
    // }
    if(empty($refreshToken)){
      $statusRefresh = false;
    }else{
      $statusRefresh = true;
    }

    $message = "";
    if(!$statusSession){
      $message = "You are not logged in.";
    }else{
      $message = "Logged in.";
    }

    if($statusSession === false){
      $content = ["stStatus" => $statusSession, "hasRt" => $statusRefresh, "message" => $message];
      send_response(false, $content, 401);
      exit;
    }
   
  }
}