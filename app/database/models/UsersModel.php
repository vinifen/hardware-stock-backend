<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;

class UsersModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    echo "contruct User Model";
    $this->pdo = $db->connect();
  }

  public function insert(string $username, string $password, string $publicUserId) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO users (username, password, public_id) VALUES (:username, :password, :public_id)");
      $stmt->bindValue(':username', $username, PDO::PARAM_STR);
      $stmt->bindValue(':password', $password, PDO::PARAM_STR);
      $stmt->bindValue(':public_id', $publicUserId, PDO::PARAM_STR);
  
      $stmt->execute(); 
      $lastInsertId = $this->pdo->lastInsertId();
      
      if (empty($lastInsertId)) {
        throw new \PDOException("Failed to retrieve last insert user ID");
      }
      
      echo "User inserted with ID: " . $lastInsertId;
      return $lastInsertId;

    } catch (\PDOException $e) {
      echo "Error inserting user: " . $e->getMessage();
      return null;
    }
  }

  public function selectUsernameAndUserIdByUsername(string $username){
    try{ 
      $stmt = $this->pdo->prepare("SELECT username, id FROM users WHERE username = ?");
      $stmt->bindValue(1, $username, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if(empty($result)){
        return null;
      }
      echo print_r($result) . " TEST DB - Select by Username";
      return $result;
    }catch (\PDOException $e){
      echo "Error retrieving username and user ID by username: " . $e->getMessage();
      return null;
    }
  }

  public function selectByUserId(int $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT public_id, created_at, username, id FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No data found for user with ID: " . $userId;
        return null;
      }

      echo print_r($result) . " TEST DB - Select by User ID";
      return $result;

    } catch (\PDOException $e) {
      echo "Error retrieving user data by user ID: " . $e->getMessage();
      return null;
    }
  }


  public function selectUserIdByPublicUserId(string $publicUserId){
    try {
      $stmt = $this->pdo->prepare("SELECT id FROM users WHERE public_id = ?");
      $stmt->bindValue(1, $publicUserId, PDO::PARAM_STR);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        echo "No user ID found for user with public ID: " . $publicUserId;
        return null; 
      }

      echo print_r($result) . " TEST DB - Select User ID by Public User ID";
      return $result[0]['id']; 

    } catch (\PDOException $e) {
      echo "Error retrieving user ID by public ID: " . $e->getMessage();
      return null;
    }
  }

  public function selectPassword(int $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_INT);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No password found for user with ID: " . $userId;
        return null; 
      }

      $password = $result[0]['password'];
      echo print_r($password) . " TEST DB - Select User Password";

      return $password;
    } catch (\PDOException $e) {
      echo "Error retrieving password for user ID: " . $e->getMessage();
      return null;
    }
  }

  public function delete(int $userId): bool {
    try { 
      $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new \PDOException("No user found with ID: $userId");
      }

      return true;
    } catch (\PDOException $e) {
      error_log("Error deleting user by ID: " . $e->getMessage());
      return false;
    }
  }

  public function alterUsername(int $userId, string $newUsername): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
      $stmt->bindValue(1, $newUsername, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
          throw new \PDOException("No user found with ID: $userId or username is the same.");
      }

      return true;
    } catch (\PDOException $e) {
        error_log("Error updating username for user ID $userId: " . $e->getMessage());
        return false;
    }
  }

  public function alterPassword(int $userId, string $newPassword): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
      $stmt->bindValue(1, $newPassword, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new \PDOException("No user found with ID: $userId or password is the same.");
      }

      return true;
    } catch (\PDOException $e) {
      error_log("Error updating password for user ID $userId: " . $e->getMessage());
      return false;
    }
  }

}
