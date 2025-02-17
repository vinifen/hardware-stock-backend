<?php
namespace core\library;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;
use Exception;

class JwtHandler{ 
  private $jwtKey;

  public function __construct($key) { 
    echo "CONTRUCT JWTHANDLER";
    $this->jwtKey = $key;
  }

  public function test($testParam){
    echo  "JWT " . $testParam . " OK ";
  }

  public function encodeToken($user) {
    try{ 
      $payload = [
          'user' => $user,
          'expiration' => time() + (86400 * 30),
      ];
      return JWT::encode($payload, $this->jwtKey, 'HS256');
    }catch (Exception $error) {
      return 'Error new token: ' . $error->getMessage();
    }
  }

  public function decodeToken($token) {
    try {
      $decoded = JWT::decode($token, new Key($this->jwtKey, 'HS256'));

      return $decoded;
    } catch (Exception $error) {
      return 'Invalid token: ' . $error->getMessage();
    }
  }

}