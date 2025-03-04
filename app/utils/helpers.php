<?php
use core\exceptions\ClientException;

function base_path(){
  return realpath(__DIR__ . '/../..');
}

function get_body(array $requiredFields = []){
  $body = json_decode(file_get_contents('php://input'), true);
  if (empty($body)) {
    throw new ClientException("No data sent");
  }
  
  // $missingFields = [];
  foreach ($requiredFields as $keyField) {
    if(!array_key_exists($keyField, $body)){
      // array_push($missingFields, $keyField);
      throw new ClientException("One or more required params are missing");
    }
  }

  // if(count($missingFields) > 0){
  //   throw new ClientException("Missing fields: " . implode(", ", $missingFields));
  // }

  return $body;
}

function send_response(bool $status, $content, int $statusCode){
  http_response_code($statusCode);
  echo json_encode([
    "status" => $status,
    "content" => $content
  ]);
}