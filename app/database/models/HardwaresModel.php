<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class HardwaresModel {
  private PDO $pdo;

  public function __construct(DBConnection $db) { $this->pdo = $db->connect(); }

  public function insert(
      string $name, 
      float $price, 
      string $userId, 
      ?int $brandId, 
      ?int $categoryId
    ) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO hardwares (name, price, user_id, brand_id, category_id) VALUES (?, ?, ?, ?, ?)");
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $price, PDO::PARAM_STR);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->bindValue(4, $brandId ?? null, is_null($brandId) ? PDO::PARAM_NULL : PDO::PARAM_INT);
      $stmt->bindValue(5, $categoryId ?? null, is_null($categoryId) ? PDO::PARAM_NULL : PDO::PARAM_INT);

      $stmt->execute(); 

      $lastInsertId = $this->pdo->lastInsertId();
      
      if (empty($lastInsertId)) {
        throw new ClientException("Failed to insert hardware. Please check your data.");
      }
      return $lastInsertId;

    } catch (\PDOException $e) {
      throw new InternalException("Error inserting hardware: " . $e->getMessage());
    }
  }
  

  public function select(int $hardwareId, string $userId) {
    try {
      $stmt = $this->pdo->prepare(
        "SELECT 
          name AS hardware_name,
          price,
          category_id,
          brand_id
         FROM hardwares WHERE id = ? AND user_id = ?"
      );
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        return null;
      }
      return $result;

    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving hardware by ID: " . $e->getMessage());
    }
  }


  public function selectRelated(int $hardwareId, string $userId) {
    try {
      $stmt = $this->pdo->prepare(
        "SELECT 
          hardwares.id AS hardware_id, 
          hardwares.name AS hardware_name, 
          hardwares.price, 
          hardwares.user_id, 
          brands.name AS brand_name, 
          categories.name AS category_name
        FROM hardwares 
        INNER JOIN brands ON hardwares.brand_id = brands.id 
        INNER JOIN categories ON hardwares.category_id = categories.id 
        WHERE hardwares.id = ? AND hardwares.user_id = ?"
      );
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        return null;
      }
      return $result;

    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving related hardware: " . $e->getMessage());
    }
  }


  public function selectAllByUserId(string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM hardwares WHERE user_id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (empty($result)) {
        return null;
      }
      return $result;

    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving hardwares for user ID: " . $userId . ": " . $e->getMessage());
    }
  }


  public function selectAllRelatedByUserId(string $userId) {
    try {
      error_log("aqui em selectAllRelatedByUserId");
      $stmt = $this->pdo->prepare(
        "SELECT 
          hardwares.id AS hardware_id, 
          hardwares.name AS hardware_name, 
          hardwares.price, 
          hardwares.user_id, 
          brands.name AS brand_name, 
          categories.name AS category_name
        FROM hardwares 
        LEFT JOIN brands ON hardwares.brand_id = brands.id 
        LEFT JOIN categories ON hardwares.category_id = categories.id 
        WHERE hardwares.user_id = ?"
      );
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();
      
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      if (empty($result)) {
        return null;
      }
      return $result;
        
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving hardwares for user ID: " . $userId . " related to brands and categories. " . $e->getMessage());
    }
  }


  public function delete(int $hardwareId, string $userId) {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM hardwares WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("Hardware not found.");
      }
      return true;

    } catch (\PDOException $e) {
      throw new InternalException("Error deleting hardware with ID: " . $hardwareId . ": " . $e->getMessage());
    }
  }

  public function alterPrice(int $hardwareId, float $newPrice, string $userId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET price = ? WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $newPrice, PDO::PARAM_STR);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("Hardware not found or price is the same.");
      }

      return true;

    } catch (\PDOException $e) {
      throw new InternalException("Error updating price for hardware ID: " . $hardwareId . ": " . $e->getMessage());
    }
  }


  public function alterName(int $hardwareId, string $newName, string $userId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET name = ? WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        throw new ClientException("Hardware not found or name is the same.");
      }
      return true;

    } catch (\PDOException $e) {
      throw new InternalException("Error updating name for hardware ID: " . $hardwareId . ": " . $e->getMessage());
    }
  }


  public function alterBrandId(int $hardwareId, int $brandId, string $userId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET brand_id = ? WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $brandId, PDO::PARAM_INT);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      }
      return false;
      
    } catch (\PDOException $e) {
      throw new InternalException("Error updating the brand_id for hardware: " . $e->getMessage());
    }
  }


  public function alterCategoryId(int $hardwareId, int $categoryId, string $userId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET category_id = ? WHERE id = ? AND user_id = ?");
      $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->bindValue(3, $userId, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } 
      return false;

    } catch (\PDOException $e) {
      throw new InternalException("Error updating the category_id for hardware: " . $e->getMessage());
    }
  }

}
