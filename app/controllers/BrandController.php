<?php

namespace app\controllers;
require_once  base_path() . "/app/controllers/handler/handleController.php";
use app\services\AuthService;
use app\services\BrandService;

class BrandController {
  public function __construct(private AuthService $authService, private BrandService $brandService) {}

  public function create() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $body = get_body(["name"]);

      $result = $this->brandService->create($body["name"], $stPayload->user_id);

      send_response(true, ["message" => $result], 201);
    }, "creating brand.");
  }

  public function get($brandsId) {
    handleController(function () use ($brandsId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $result = $this->brandService->get($brandsId, $stPayload->user_id);

      send_response(true, ["message" => "Brand data successfully obtained.", "data" => $result], 200);
    }, "getting brand.");
  }

  public function getAllByUserId() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $result = $this->brandService->getAllByUserId($stPayload->user_id);

      send_response(true, ["message" => "All brands data successfully obtained.", "data" => $result], 200);
    }, "getting all brands.");
  }

  public function update($brandsId) {
    handleController(function () use ($brandsId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $body = get_body(["name"]);

      $result = $this->brandService->updateName($brandsId, $body["name"], $stPayload->user_id);

      send_response(true, ["message" => $result], 200);
    }, "updating brand.");
  }

  public function delete($brandsId) {
    handleController(function () use ($brandsId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->brandService->brandModel->delete($brandsId, $stPayload->user_id);
      
      send_response(true, ["message" => "Brand successfully deleted."], 200);
    }, "deleting brand.");
  }
  
}
