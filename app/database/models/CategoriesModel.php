<?php
namespace app\database\models;

use app\database\DBConnection;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use \PDO;

class CategoriesModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    echo "construct CategoriesModel";
    $this->pdo = $db->connect();
  }

  public function insert(string $name, string $userId) {
    try {
      $stmt = $this->pdo->prepare("INSERT INTO categories (name, users_id) VALUES (? , ?)");
      $stmt->bindValue(1, $name, PDO::PARAM_STR);
      $stmt->bindValue(2, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $lastInsertId = $this->pdo->lastInsertId();
      if (empty($lastInsertId)) {
        throw new ClientException("Failed to insert category. Please check your input.");
      }

      echo "Category inserted with ID: " . $lastInsertId;
      return $lastInsertId;
    } catch (\PDOException $e) {
      throw new InternalException("Error inserting category: " . $e->getMessage());
    }
  }

  public function select(int $categoryId) {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
      $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No data found for category with ID: " . $categoryId;
        return null;
      }

      echo print_r($result, true) . " TEST DB - Select Category";
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving category data for category ID: " . $e->getMessage());
    }
  }

  public function selectAllUserId(string $userId){
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE users_id = ?");
      $stmt->bindValue(1, $userId, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        echo "No data found for category with user ID: " . $userId;
        return null;
      }

      echo print_r($result, true) . " TEST DB - Select Category";
      return $result;
    } catch (\PDOException $e) {
      throw new InternalException("Error retrieving category data for user ID: " . $e->getMessage());
    }
  }

  public function alter(int $categoryId, string $newName): bool {
    try {
      $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
      $stmt->bindValue(1, $newName, PDO::PARAM_STR);
      $stmt->bindValue(2, $categoryId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No category found with ID: " . $categoryId . " or name is the same.";
        return false;
      }

      echo "Category name updated successfully for category ID: " . $categoryId;
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error updating category name for category ID $categoryId: " . $e->getMessage());
    }
  }

  public function delete(int $categoryId): bool {
    try {
      $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
      $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "No category found with ID: " . $categoryId;
        return false;
      }

      echo "Category with ID: " . $categoryId . " deleted successfully.";
      return true;
    } catch (\PDOException $e) {
      throw new InternalException("Error deleting category with ID $categoryId: " . $e->getMessage());
    }
  }
}
