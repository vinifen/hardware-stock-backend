<?php
namespace app\database;

use Exception;
use PDO;

class DBConnection {
  private $host;
  private $port;
  private $dbName;
  private $user;
  private $password;

  public function __construct() {
    echo "contruct DATABASE Model";
    $this->host = $_ENV['DB_HOST'];
    $this->port = $_ENV['DB_PORT'];
    $this->dbName = $_ENV['DB_NAME'];
    $this->user = $_ENV['DB_USER'];
    $this->password = $_ENV['DB_PASSWORD'];
  }

  public function connect() {
    try {
      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName}";
      $pdo = new PDO($dsn, $this->user, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      echo "Postgresql connected";
      return $pdo;
    } catch (Exception $e) {
      echo "Error connect Postgresql: " . $e->getMessage();
      return null;
    }
  }

}
