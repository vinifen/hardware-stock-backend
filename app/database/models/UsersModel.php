<?php
namespace app\database\models;

use app\database\DBConnection;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use \PDO;

class UsersModel {
  private PDO $pdo;

  public function __construct(DBConnection $db) { $this->pdo = $db->connect(); }

  public function insert(string $username, string $password, string $userId) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO users (username, password, id) VALUES (?, ?, ?)");
      $stmt->bindValue(1, $username, PDO::PARAM_STR);
      $stmt->bindValue(2, $password, PDO::PARAM_STR);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
  
      $stmt->execute(); 
      
      $lastInsertId = $this->pdo->lastInsertId();
      if (empty($lastInsertId)) {
        throw new ClientException("Failed to insert user. Please check your credentials.");
      }
      
      return $lastInsertId;

    } catch (\PDOException $e) {
      throw new InternalException("Error inserting user: " . $e->getMessage());
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

      return $result;

    }catch (\PDOException $e){
      throw new InternalException("Error retrieving username and user ID by username: " . $e->getMessage());
    }
  }

  public function select(string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT created_at, username, id FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        return null;
      }

      return $result;

    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving user data by user ID: " . $e->getMessage());
    }
  }


  public function selectPassword(string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        return null; 
      }

      $password = $result['password'];
      return $password;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving password for user ID: " . $e->getMessage());
    }
  }


  public function delete(string $userId): bool {
    try { 
      $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("User not found.");
      }

      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error deleting user by ID: " . $e->getMessage());
    }
  }


  public function alterUsername(string $userId, string $newUsername): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
      $stmt->bindValue(1, $newUsername, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("User not found or username is the same.");
      }

      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error updating username for user ID $userId: " . $e->getMessage());
    }
  }


  public function alterPassword(string $userId, string $newPassword): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
      $stmt->bindValue(1, $newPassword, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("User not found or password is the same.");
      }

      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error updating password for user ID $userId: " . $e->getMessage());
    }
  }

}
