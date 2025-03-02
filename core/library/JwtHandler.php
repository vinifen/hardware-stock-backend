<?php
namespace core\library;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;
use core\exceptions\InternalException;

class JwtHandler{ 

  public function __construct(private $jwtKey) {
    echo "CONTRUCT JWTHANDLER";
  }

  public function test($testParam){
    echo  "JWT " . $testParam . " OK ";
  }

  public function encodeToken($payload) {
    try{ 
      return JWT::encode($payload, $this->jwtKey, 'HS256');
    }catch (InternalException $error) {
      return 'Error new token: ' . $error->getMessage();
    }
  }

  public function decodeToken($token) {
    try {
      $decoded = JWT::decode($token, new Key($this->jwtKey, 'HS256'));

      return $decoded;
    } catch (InternalException $error) {
      return 'Invalid token: ' . $error->getMessage();
    }
  }

}