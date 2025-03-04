<?php
namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleController.php";

use app\services\AuthService;
use app\services\HardwareService;

class HardwareController {

  public function __construct(private HardwareService $hardwareService, private AuthService $authService) {}

  public function create() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $body = get_body(["name", "price"]);

      if (!isset($body["brand_id"])) {
        $body["brand_id"] = null;
      }
      if (!isset($body["category_id"])) {
        $body["category_id"] = null;
      }

      $this->hardwareService->checkHardwareRelated($body["brand_id"], $body["category_id"], $stPayload->user_id);
      $resultHardware = $this->hardwareService->create($body["name"], $body["price"], $stPayload->user_id, $body["brand_id"], $body["category_id"]);

      send_response(true, ["message"=>$resultHardware], 201);
    }, "creating hardware");
  }

  public function get($hardwareId) {
    handleController(function () use ($hardwareId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $result = $this->hardwareService->get($hardwareId, $stPayload->user_id);

      send_response(true, ["message"=>"Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware");
  }

  public function getRelated($hardwareId) {
    handleController(function () use ($hardwareId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      
      $result = $this->hardwareService->getRelated($hardwareId, $stPayload->user_id);

      send_response(true, ["message"=>"Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware related");
  }

  public function getAllByUser() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $result = $this->hardwareService->getAllByUserId($stPayload->user_id);

      send_response(true, ["message"=>"Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting all hardwares");
  }

  public function getAllRelatedByUser() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
 
      $result = $this->hardwareService->getAllRelatedByUserId($stPayload->user_id);

      send_response(true, ["message"=>"Related Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware");
  }

  public function updateName($hardwareId) {
    handleController(function () use ($hardwareId) {
      $body = get_body(["name"]);
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $result = $this->hardwareService->updateName($hardwareId, $body["name"], $stPayload->user_id);

      send_response(true, ["message"=>$result], 200);
    }, "updating hardware name");
  }

  public function updateBrand(int $hardwareId) {
    handleController(function () use ($hardwareId) {
      $body = get_body(["brand_id"]);
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->hardwareService->checkHardwareRelated($body["brand_id"], null, $stPayload->user_id);

      $this->hardwareService->hardwareModel->alterBrandId($hardwareId, $body["brand_id"], $stPayload->user_id);

      send_response(true, ["message"=>"Hardware brand successfully updated."], 200);
    }, "updating hardware brand.");
  }

  public function updateCategory(int $hardwareId) {
    handleController(function () use ($hardwareId) {
      $body = get_body(["category_id"]);
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->hardwareService->checkHardwareRelated(null, $body["category_id"], $stPayload->user_id);

      $this->hardwareService->hardwareModel->alterCategoryId($hardwareId, $body["category_id"], $stPayload->user_id);

      send_response(true, ["message"=>"Hardware category successfully updated."], 200);

    }, "updating hardware category.");
  }

  public function delete(int $hardwareId) {
    handleController(function () use ($hardwareId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->hardwareService->hardwareModel->delete($hardwareId, $stPayload->user_id);

      send_response(true, ["message"=>"Hardware successfully deleted."], 200);

    }, "deleting hardware.");
  }

}
