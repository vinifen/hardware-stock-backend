<?php
namespace app\services;

use app\database\models\RefreshTokensModel;
use app\database\models\UsersModel;
use core\library\JwtHandler;
use Psr\Container\ContainerInterface;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use core\validation\UserValidator;
use Ramsey\Uuid\Uuid;
use app\utils\JwtUtils;


class AuthService{
  private $jwtSessionHandler;
  private $jwtRefreshHandler;

  public function __construct(
    private RefreshTokensModel $refreshTokensModel,
    private UsersModel $userModel,
    ContainerInterface $container
  ) {
    $this->jwtSessionHandler = $container->get(JwtHandler::class . 'session');
    $this->jwtRefreshHandler = $container->get(JwtHandler::class . 'refresh');
  }

  public function login(string $username, string $password, array $payload = []) {
    try { 
      $result = $this->verifyUsername($username);
      $userId = $result["id"];

      $this->verifyPassword($password, $userId);

      $userData = $this->userModel->select($userId);
      unset($userData["id"]);

      $payload = $this->tokensPayload($userData, $payload);

      $sessionToken = $this->jwtSessionHandler->encodeToken(JwtUtils::generateSessionPayload($payload));
      $refreshToken = $this->jwtRefreshHandler->encodeToken(JwtUtils::generateRefreshPayload($payload));

      $hashRefreshToken = hash('sha256', $refreshToken);
      $rtId = Uuid::uuid7();
      
      $this->refreshTokensModel->insert($hashRefreshToken, $userId, $rtId);
      return [
        'sessionToken' => $sessionToken,
        'refreshToken' => $refreshToken,
      ];
    } catch (ClientException | InternalException $e) {
      throw $e;
    } catch (\Exception $e) {
      throw $e;
    }
  }

  private function tokensPayload(array $userData, array $payload = []){
    $payload = array_merge([
      "user_id"=>$userData["public_id"],
      "username"=>$userData["username"]
    ], $payload);
    return $payload;
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
    } catch (ClientException | InternalException $e){
      echo "aqui em asdf32323232333333";
      throw $e;
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
    } catch (ClientException $e) {
      throw $e; 
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
    } catch (ClientException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

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