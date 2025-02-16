<?php
namespace app\database\models;

use app\database\DBConnection;
use \PDO;

class RefreshTokensModel {
  private PDO $pdo;

  public function __construct(DBConnection $db)
  {
    $this->pdo = $db->connect();
  }

  public function insert(string $token, int $userId){
    $stmt = $this->pdo->prepare("INSERT INTO refresh_tokens VALUES (:token, :users_id)");
  }
}