<?php

use core\exceptions\ClientException;

function base_path(){
  return realpath(__DIR__ . '/../..');
}

function get_body(){
  $body = json_decode(file_get_contents('php://input'), true);

  if (empty($body)) {
    throw new ClientException("No data sent");
  }

  return $body;
}


function send_response(bool $status, $content, int $statusCode){
  http_response_code($statusCode);
  echo json_encode([
    "status" => $status,
    "content" => $content
  ]);
  exit;
}