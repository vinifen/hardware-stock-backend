<?php
namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleController.php";

use app\services\AuthService;
use app\utils\JwtUtils;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use core\config\Variables;

class AuthController {
  public function __construct(private AuthService $authService) {}

  public function login() {
    handleController(function () {
      $body = get_body(["username", "password"]);

      $resultUsername = $this->authService->verifyUsername($body["username"]);
      $userId = $resultUsername["id"];

      $this->authService->verifyPassword($body["password"], $userId);

      $result = $this->authService->getNewTokens($userId);
      
      setcookie("token1", $result["sessionToken"], [
        'expires'=>JwtUtils::sessionExpiration(),
        'path'=>'/',
        'secure'=>Variables::cookie_secure(),
        'httponly'=>Variables::cookie_http_only()
      ]);

      setcookie("token2", $result["refreshToken"], [
        'expires'=>JwtUtils::refreshExpiration(),
        'path'=>'/',
        'secure'=>Variables::cookie_secure(),
        'httponly'=>Variables::cookie_http_only()
      ]);

      send_response(true, ["message"=> "User logged in successfully"], 200);
      
    }, "loggin in");

  }
  
  public function getNewSession() {
    handleController(function (){ 
      echo "teste 1";
      if(!isset($_COOKIE["token2"])){
        throw new ClientException("No token found.");
      }
      $resultVerify = $this->authService->verifyRefreshToken($_COOKIE["token2"]);
      echo "ASIERUIUHACACHORRROOO" . var_dump( $resultVerify->user_id);
      $newTokens = $this->authService->getNewTokens($resultVerify->user_id); 

      $this->authService->removeRefreshToken($_COOKIE["token2"]);
      
      setcookie("token1", $newTokens["sessionToken"], [
        'expires'=>JwtUtils::sessionExpiration(),
        'path'=>'/',
        'secure'=>Variables::cookie_secure(),
        'httponly'=>Variables::cookie_http_only()
      ]);

      setcookie("token2", $newTokens["refreshToken"], [
        'expires'=>JwtUtils::refreshExpiration(),
        'path'=>'/',
        'secure'=>Variables::cookie_secure(),
        'httponly'=>Variables::cookie_http_only()
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
