<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;

class CategoriesModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    $this->pdo = $db->connect();
  }

  public function insert(string $name) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      $stmt->execute(); 

      $lastInsertId = $this->pdo->lastInsertId();
      
      if (empty($lastInsertId)) {
        throw new \PDOException("Failed to retrieve last insert category ID");
      }
      
      echo "Category inserted with ID: " . $lastInsertId;
      return $lastInsertId;

    } catch (\PDOException $e) {
      echo "Error inserting category: " . $e->getMessage();
    }
  }

  public function alter(int $categoriesId, string $newName) {
    try {
      $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $categoriesId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No category found with ID: " . $categoriesId . " or name is the same.";
        return false;
      }

      echo "Category name updated successfully for category ID: " . $categoriesId;
      return true;

    } catch (\PDOException $e) {
      echo "Error updating category name for category ID: " . $categoriesId . ": " . $e->getMessage();
    }
  }

  public function delete(int $categoriesId) {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
      $stmt->bindValue(1, $categoriesId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No category found with ID: " . $categoriesId;
        return false;
      }

      echo "Category with ID: " . $categoriesId . " deleted successfully.";
      return true;

    } catch (\PDOException $e) {
      echo "Error deleting category with ID: " . $categoriesId . ": " . $e->getMessage();
    }
  }
}
