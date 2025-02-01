<?php
namespace app\database;

use Exception;
use mysqli;

class DbHandler{
  private $mysqli;

  public function __construct(
    string $servername,
    string $username,
    string $password,
    string $dbname 
  ) {
    $this->mysqli = new mysqli($servername, $username, $password, $dbname);
    if($this->mysqli->connect_error){
      die("Database onnection failed: " . $this->mysqli->connect_error);
    }
  }

  public function executeQuery(string $query, array $params = []){
    try {
      $stmt = $this->mysqli->prepare($query);

      if(!empty($params)){ 
        $paramsTypes = $this->defineParamsType($params);
        $stmt->bind_param($paramsTypes, ...$params);
      }

      $stmt->execute();

      if(stripos($query, 'SELECT') !== false){
        $response = $stmt->get_result();
        $result = $response->fetch_assoc();
        $stmt->close();
        return $result;
      }
      
      $stmt->close();
      return true;

    } catch (\Throwable $e) {
      error_log("[MySQL Query Error in executeQuery():]" . $e->getMessage());
      return false;
    }

  }

  private function defineParamsType($params){
    $types = '';  
    foreach ($params as $param) {
      if (is_int($param)) {
        $types .= 'i';
      } elseif (is_float($param)) {
        $types .= 'd'; 
      } elseif (is_string($param)) {
        $types .= 's';
      } else {
        throw new Exception("Unsupported parameter type");
      }
    }
    return $types;
  }
  
}