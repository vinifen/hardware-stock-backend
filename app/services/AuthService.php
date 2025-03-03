<?php
namespace app\services;


use app\database\models\RefreshTokensModel;
use app\database\models\UsersModel;
use core\library\JwtHandler;
use Psr\Container\ContainerInterface;
use core\exceptions\ClientException;
use core\validation\UserValidator;
use app\utils\JwtUtils;


class AuthService{
  public $jwtSessionHandler;
  public $jwtRefreshHandler;

  public function __construct(
    private RefreshTokensModel $refreshTokensModel,
    private UsersModel $userModel,
    ContainerInterface $container
  ) {
    $this->jwtSessionHandler = $container->get(JwtHandler::class . 'session');
    $this->jwtRefreshHandler = $container->get(JwtHandler::class . 'refresh');
  }

  private function createRefreshToken($payloadData){
    try {
      $rtPayload = JwtUtils::generateRefreshPayload($payloadData);
      $rtId = $rtPayload["token_id"];
      $userId = $payloadData["user_id"];

      $refreshToken = $this->jwtRefreshHandler->encodeToken($rtPayload);

      $hashRefreshToken = hash('sha256', $refreshToken);

      $this->refreshTokensModel->insert($hashRefreshToken, $userId, $rtId);
      return $refreshToken;
    } catch (\Exception $e) {
      throw $e;
    }
  }


  public function verifyUsername(string $username){
    try {
      UserValidator::username($username);
      $result = $this->userModel->selectUsernameAndUserIdByUsername($username);
      if(empty($result) || $result["username"] !== $username){
        throw new ClientException("User does not exist");
      }

      echo $result["id"] . $result["id"] . "RESULT VEIRFYUSERNAME";
      return $result;
    } catch (\Exception $e) {
      echo "aqui em asdf32323232333333";
      throw $e;
    }
  }

  public function verifyPassword(string $password, string $userId){
    try{ 
      UserValidator::password($password);
      echo "AQUIASDFAS";
      $hashPassword = $this->userModel->selectPassword($userId);
      if(!password_verify($password, $hashPassword)){
        throw new ClientException("Invalid credentials");
      }
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function encryptPassword(string $password){
    try {
      UserValidator::password($password);
      $hashPassword = password_hash($password, PASSWORD_BCRYPT);
      echo $hashPassword . "HASH PASSWORD";
      return $hashPassword;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function removeRefreshToken(string $refreshToken){
    try {
      $rtPayload = $this->jwtRefreshHandler->decodeToken($refreshToken);
      $this->refreshTokensModel->delete($rtPayload->token_id);
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function verifyRefreshToken(string $refreshToken){
    echo  "chego";
    try {
      $rtPayload = $this->jwtRefreshHandler->decodeToken($refreshToken);
      $resultRefreshToken = $this->refreshTokensModel->select($rtPayload->token_id, $rtPayload->user_id);

      if(empty($resultRefreshToken)){
        throw new ClientException("Invalid refresh token");
      }
      if($resultRefreshToken["token"] !== hash('sha256', $refreshToken)){
        throw new ClientException("Invalid refresh token");
      }
      
      return $rtPayload;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getNewTokens(string $userId){
    try {
      $payloadUser = [
        "user_id"=>$userId,
      ];
      
      $sessionToken = $this->jwtSessionHandler->encodeToken(JwtUtils::generateSessionPayload($payloadUser));
      $refreshToken = $this->createRefreshToken($payloadUser);

      return [
        'sessionToken' => $sessionToken,
        'refreshToken' => $refreshToken,
      ];
      
    } catch (\Exception $e){
      throw $e;
    }
  }

  // public function login(string $username, string $password) {
  //   try { 
  //     $result = $this->verifyUsername($username);
  //     $userId = $result["id"];

  //     $this->verifyPassword($password, $userId);

  //     $userData = $this->userModel->select($userId);

  //     $payloadUser = [
  //       "user_id"=>$userData["id"],
  //       "username"=>$userData["username"]
  //     ];
      

  //     $sessionToken = $this->jwtSessionHandler->encodeToken(JwtUtils::generateSessionPayload($payloadUser));
  //     $refreshToken = $this->createRefreshToken($payloadUser);

  //     return [
  //       'sessionToken' => $sessionToken,
  //       'refreshToken' => $refreshToken,
  //     ];
  //   } catch (\Exception $e) {
  //     throw $e;
  //   }
  // }

  // private function tokensUserPayload(array $data){
  //   $payload = [
  //     "user_id"=>$data["id"],
  //     "username"=>$data["username"]
  //   ];
  //   return $payload;
  // } 

  // public function verifyUser(string $publicUserId){
  //   try {
  //     $result = $this->userModel->selectUserIdAndUsernameByPublicId($publicUserId);
  //     if(empty($result)){
  //       throw new ClientException("User does not exist");
  //     }
  //     $payload = $this->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
  //     echo var_dump($payload->public_user_id) . "PAYLOADzzzzzzzzz";
  //     if($payload->public_user_id !== $publicUserId){
  //       throw new ClientException("Invalid user");
  //     }
  //     return $result;
  //   } catch (ClientException | InternalException $e){
  //     throw $e;
  //   } catch (\Exception $e) {
  //     throw $e;
  //   }
  // }

}