<?php
namespace app\database\models;

use app\database\DBConnection;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use \PDO;

class RefreshTokensModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    $this->pdo = $db->connect();
  }

  public function insert(string $token, int $userId, string $rtUuid): bool {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO refresh_tokens (uuid, users_id, token) VALUES (?, ?, ?)");
      $stmt->bindValue(1, $rtUuid, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_INT);
      $stmt->bindValue(3, $token, PDO::PARAM_STR);
      
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {
        throw new ClientException("Failed to insert refresh token.");
      }
      
      echo "Refresh token inserted with ID: " . $rtUuid;
      
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error inserting refresh token: " . $e->getMessage());
    }
  }


  public function select(string $rtUuid, int $userId): ?array {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM refresh_tokens WHERE uuid = ? AND users_id = ?");
      $stmt->bindValue(1, $rtUuid, PDO::PARAM_STR);
      $stmt->bindValue(1, $userId, PDO::PARAM_INT);
      $stmt->execute();
      
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      if (empty($result)) {
        echo "No data found for refresh token with ID: " . $rtUuid;
        return null;
      }
      
      echo print_r($result, true) . " TEST DB - Select refresh token ID";
      
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving refresh token: " . $e->getMessage());
    }
  }


  public function delete(string $rtUuid): bool {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM refresh_tokens WHERE uuid = ?");
      $stmt->bindValue(1, $rtUuid, PDO::PARAM_STR);
      $stmt->execute();
      
      if ($stmt->rowCount() === 0) {
        echo "No refresh token found with ID: " . $rtUuid;
        throw new ClientException("Refresh token not found.");
      }
      
      echo "Refresh token with ID: " . $rtUuid . " deleted successfully.";
      
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error deleting refresh token: " . $e->getMessage());
    }
  }
  
}
