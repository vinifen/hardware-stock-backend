<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;

class HardwaresModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    echo "contruct Hardware Model";
    $this->pdo = $db->connect();
  }

  public function insert(string $name, float $price, int $userId) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO hardwares (name, price, users_id) VALUES (:name, :price, :users_id)");
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->bindValue(':price', $price, PDO::PARAM_STR);
      $stmt->bindValue(':users_id', $userId, PDO::PARAM_INT);

      $stmt->execute(); 

      $lastInsertId = $this->pdo->lastInsertId();
      
      if (empty($lastInsertId)) {
        throw new \PDOException("Failed to retrieve last insert hardware ID");
      }
      
      echo "Hardware inserted with ID: " . $lastInsertId;
      return $lastInsertId;

    } catch (\PDOException $e) {
      echo "Error inserting hardware: " . $e->getMessage();
    }
  }


  public function select(string $hardwareId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM hardwares WHERE id = ?");
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        echo "No data found for hardware with ID: " . $hardwareId;
        return null;
      }

      echo print_r($result) . " TEST DB - Select hardware ID";
      return $result;

    } catch (\PDOException $e) {
      echo "Error retrieving hardware by ID: " . $e->getMessage();
    }
  }


  public function selectRelated(int $hardwareId){
    try {
      $stmt = $this->pdo->prepare(
        "SELECT 
          hardwares.id AS hardware_id, 
          hardwares.name AS hardware_name, 
          hardwares.price, 
          hardwares.users_id, 
          brands.name AS brand_name, 
          categories.name AS category_name
        FROM hardwares 
        INNER JOIN brands ON hardwares.brands_id = brands.id 
        INNER JOIN categories ON hardwares.categories_id =  categories.id 
        WHERE hardwares.id = ?"
      );
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($result)) {
        echo "No data found for related hardware with brands and categories with ID: " . $hardwareId;
        return null;
      }

      echo print_r($result) . " TEST DB - Select related hardware with brands and categories by hardware ID";
      return $result;

    } catch (\PDOException $e) {
      echo "Error retrieving related hardware with brands and categories with ID: " . $e->getMessage();
    }
  }


  public function selectAllRelatedByUserId(int $userId) {
    try {
      $stmt = $this->pdo->prepare(
        
        //ESTUDAR MAIS ISSO principalmente COALESCE

        "SELECT 
          hardwares.id AS hardware_id, 
          hardwares.name AS hardware_name, 
          hardwares.price, 
          hardwares.users_id, 
          brands.name AS brand_name, 
          categories.name AS category_name
        FROM hardwares 
        LEFT JOIN brands ON hardwares.brands_id = brands.id 
        LEFT JOIN categories ON hardwares.categories_id = categories.id 
        WHERE hardwares.users_id = ?"
      );
      $stmt->bindValue(1, $userId, PDO::PARAM_INT);
      $stmt->execute();
      
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      if (empty($result)) {
        echo "No hardwares found for user with ID: " . $userId . " related to brands and categories.";
        return null;
      }
      
      echo print_r($result) . " TEST DB - Select hardwares for user ID with brands and categories";
      return $result;
        
    } catch (\PDOException $e) {
      echo "Error retrieving hardwares for user ID: " . $userId . " related to brands and categories. " . $e->getMessage();
    }
  }


  public function delete(int $hardwareId){
    try {
      $stmt = $this->pdo->prepare("DELETE FROM hardwares WHERE id = ?");
      $stmt->bindValue(1, $hardwareId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
          echo "No hardware found with ID: " . $hardwareId;
          return false;
      }

      echo "Hardware with ID: " . $hardwareId . " deleted successfully.";
      return true;

    } catch (\PDOException $e) {
      echo "Error deleting hardware with ID: " . $hardwareId . ": " . $e->getMessage();
    }
  }


  public function alterPrice(int $hardwareId, float $newPrice) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET price = ? WHERE id = ?");
      $stmt->bindValue(1, $newPrice, PDO::PARAM_STR);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
          echo "No hardware found with ID: " . $hardwareId . " or price is the same.";
          return false;
      }

      echo "Price updated successfully for hardware ID: " . $hardwareId;
      return true;

    } catch (\PDOException $e) {
      echo "Error updating price for hardware ID: " . $hardwareId . ": " . $e->getMessage();
    }
  }


  public function alterName(int $hardwareId, string $newName) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET name = ? WHERE id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No hardware found with ID: " . $hardwareId . " or name is the same.";
        return false;
      }

      echo "Name updated successfully for hardware ID: " . $hardwareId;
      return true;

    } catch (\PDOException $e) {
      echo "Error updating name for hardware ID: " . $hardwareId . ": " . $e->getMessage();
    }
  }
  

  public function alterBrandId(int $hardwareId, int $brandId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET brands_id = ? WHERE id = ?");
      
      $stmt->bindValue(1, $brandId, PDO::PARAM_INT);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      
      $stmt->execute();
      
      if ($stmt->rowCount() > 0) {
        echo "Brand ID for hardware with ID {$hardwareId} has been updated to {$brandId}.";
        return true;
      } else {
        echo "No hardware found with ID {$hardwareId}, or the brand_id is already up to date.";
        return false;
      }
    } catch (\PDOException $e) {
      echo "Error updating the brand_id for hardware: " . $e->getMessage();
    }
  }


  public function alterCategorieId(int $hardwareId, int $categorieId) {
    try {
      $stmt = $this->pdo->prepare("UPDATE hardwares SET categories_id = ? WHERE id = ?");
      
      $stmt->bindValue(1, $categorieId, PDO::PARAM_INT);
      $stmt->bindValue(2, $hardwareId, PDO::PARAM_INT);
      
      $stmt->execute();
      
      if ($stmt->rowCount() > 0) {
        echo "Category ID for hardware with ID {$hardwareId} has been updated to {$categorieId}.";
        return true;
      } else {
        echo "No hardware found with ID {$hardwareId}, or the categories_id is already up to date.";
        return false;
      }
    } catch (\PDOException $e) {
      echo "Error updating the categories_id for hardware: " . $e->getMessage();
    }
  }


}
