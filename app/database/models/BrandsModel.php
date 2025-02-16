<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;

class BrandsModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    $this->pdo = $db->connect();
  }

  public function insert(string $name) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO brands (name) VALUES (:name)");
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->execute(); 

      $lastInsertId = $this->pdo->lastInsertId();
      
      if (empty($lastInsertId)) {
        throw new \PDOException("Failed to retrieve last insert brand ID");
      }
      
      echo "Brand inserted with ID: " . $lastInsertId;
      return $lastInsertId;

    } catch (\PDOException $e) {
      echo "Error inserting brand: " . $e->getMessage();
    }
  }

  public function alter(int $brandId, string $newName) {
    try {
      $stmt = $this->pdo->prepare("UPDATE brands SET name = ? WHERE id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $brandId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No brand found with ID: " . $brandId . " or name is the same.";
        return false;
      }

      echo "Brand name updated successfully for brand ID: " . $brandId;
      return true;

    } catch (\PDOException $e) {
      echo "Error updating brand name for brand ID: " . $brandId . ": " . $e->getMessage();
    }
  }

  public function delete(int $brandId) {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM brands WHERE id = ?");
      $stmt->bindValue(1, $brandId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No brand found with ID: " . $brandId;
        return false;
      }

      echo "Brand with ID: " . $brandId . " deleted successfully.";
      return true;

    } catch (\PDOException $e) {
      echo "Error deleting brand with ID: " . $brandId . ": " . $e->getMessage();
    }
  }
}
