<?php
namespace app\database\models;

use app\database\DBConnection;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use \PDO;

class RefreshTokensModel {
  private PDO $pdo;

  public function __construct(DBConnection $db) { $this->pdo = $db->connect(); }

  public function insert(string $token, string $userId, string $rtId): bool {
    try {
      $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));
      $stmt = $this->pdo->prepare("INSERT INTO refresh_tokens (id, user_id, token, expires_at) VALUES (?, ?, ?, ?)");
      $stmt->bindValue(1, $rtId, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->bindValue(3, $token, PDO::PARAM_STR);
      $stmt->bindValue(4, $expiresAt, PDO::PARAM_STR);
      
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {
        throw new ClientException("Failed to insert refresh token.");
      }
      
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error inserting refresh token: " . $e->getMessage());
    }
  }


  public function select(string $rtId, string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM refresh_tokens WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $rtId, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if (empty($result)) {
        return null;
      }
     
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving refresh token: " . $e->getMessage());
    }
  }


  public function delete(string $rtId): bool {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM refresh_tokens WHERE id = ?");
      $stmt->bindValue(1, $rtId, PDO::PARAM_STR);
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {
        throw new ClientException("Refresh token not found.");
      }
      
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error deleting refresh token: " . $e->getMessage());
    }
  }
  
}
