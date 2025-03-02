<?php
namespace app\database\models;

use app\database\DBConnection;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use \PDO;

class BrandsModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    echo "construct Brand Model";
    $this->pdo = $db->connect();
  }

  public function insert(string $name, string $userId) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO brands (name, users_id) VALUES (?,?)");
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $lastInsertId = $this->pdo->lastInsertId();
      if (empty($lastInsertId)) {
        throw new ClientException("Failed to insert brand. Please check your input.");
      }

      echo "Brand inserted with ID: " . $lastInsertId;
      return $lastInsertId;
    } catch (\PDOException $e) {
      throw new InternalException("Error inserting brand: " . $e->getMessage());
    }
  }


  public function select(int $brandId, string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM brands WHERE id = ? AND users_id = ?");
      $stmt->bindValue(1, $brandId, PDO::PARAM_INT);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No data found for brand with ID: " . $brandId;
        return null;
      }

      echo print_r($result, true) . " TEST DB - Select Brand";
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving brand data for brand ID: " . $e->getMessage());
    }
  }


  public function selectAllUserId(string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM brands WHERE users_id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No data found for brand with user ID: " . $userId;
        return null;
      }

      echo print_r($result, true) . " TEST DB - Select Brand";
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving brand data for user ID: " . $e->getMessage());
    }
  }


  public function alter(int $brandId, string $newName, string $userId): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE brands SET name = ? WHERE id = ? AND users_id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $brandId, PDO::PARAM_INT);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("Brand not found or name is the same.");
      }

      echo "Brand name updated successfully for brand ID: " . $brandId;
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error updating brand name for brand ID $brandId: " . $e->getMessage());
    }
  }
  

  public function delete(int $brandId, string $userId): bool {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM brands WHERE id = ? AND users_id = ?");
      $stmt->bindValue(1, $brandId, PDO::PARAM_INT);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("Brand not found.");
      }

      echo "Brand with ID: " . $brandId . " deleted successfully.";
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error deleting brand with ID $brandId: " . $e->getMessage());
    }
  }
}
