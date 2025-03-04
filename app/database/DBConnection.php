<?php
namespace app\database;

use core\exceptions\InternalException;
use Exception;
use PDO;
use core\config\Variables;

class DBConnection {
  private $host;
  private $port;
  private $dbName;
  private $user;
  private $password;

  public function __construct() {
    $this->host = Variables::DB_HOST();
    $this->port = Variables::DB_PORT();
    $this->dbName = Variables::DB_NAME();
    $this->user = Variables::DB_USER();
    $this->password = Variables::DB_PASSWORD();
  }

  public function connect() {
    try {
      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName}";
      $pdo = new PDO($dsn, $this->user, $this->password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $pdo;
    } catch (Exception $e) {
      throw new InternalException("Error connecting to Postgresql: " . $e->getMessage());
    }
  }

}
