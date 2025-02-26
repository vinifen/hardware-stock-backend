<?php
namespace app\controllers;
require_once  base_path() . "/app/controllers/handler/handleControllerRequest.php";
use app\database\models\HardwaresModel;
use app\services\AuthService;
use app\services\HardwareService;

class HardwareController {

  public function __construct(private HardwareService $hardwareService, private AuthService $authService) {}


  //arrumar aqui
  public function create($userId) {
    handleControllerRequest(function () use ($userId) {
      $body = get_body();
      $resultHardware = $this->hardwareService->create($body["name"], $body["price"], $userId, $body["brand_id"], $body["category_id"]);
      send_response(true, ["message"=>$resultHardware], 201);
    }, "creating hardware");
  }

  public function get($userId, $hardwareId) {
    handleControllerRequest(function () use ($userId ,$hardwareId) {
      $result = $this->hardwareService->get($hardwareId);
      send_response(true, ["message"=>"Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware");
  }

  public function getRelated($hardwareId) {
    echo "GET /hardwares/related/{$hardwareId} - Param: " . $hardwareId;
  }

  public function getAllByUser($userId) {
    handleControllerRequest(function () use ($userId) {
      $result = $this->hardwareService->getAllByUserId($userId);
      send_response(true, ["message"=>"Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware");
  }

  public function getAllRelatedByUser($userId) {
    echo "ASFDIUIGUYASIYUGAFGIYUFAIGFVTYFUIVTYFG678WF6798A67T3428IUT7632F7632FT6723GUIF7TY2T73FG623F87U3YFG76YU";
    handleControllerRequest(function () use ($userId) {
      $result = $this->hardwareService->getAllRelatedByUserId($userId);
      send_response(true, ["message"=>"Related Hardware data successfully obtained", "data"=>$result], 200);
    }, "getting hardware");
  }

  public function updateName($userId, $hardwareId) {
    handleControllerRequest(function () use ($userId, $hardwareId) {
      $body = get_body();
      $this->hardwareService->updateName($hardwareId, $body["name"]);
      send_response(true, ["message"=>"Hardware name successfully updated"], 200);
    }, "updating hardware name");
  }

  public function updateBrand(string $userId, int $hardwareId) {
    handleControllerRequest(function () use ($userId, $hardwareId) {
      $body = get_body();
      $this->hardwareService->updateBrand($hardwareId, $body["brand_id"]);
      send_response(true, ["message"=>"Hardware brand successfully updated"], 200);
    }, "updating hardware brand");
  }

  public function updateCategory(string $userId, int $hardwareId) {
    handleControllerRequest(function () use ($userId, $hardwareId) {
      $body = get_body();
      $this->hardwareService->updateCategory($hardwareId, $body["category_id"]);
      send_response(true, ["message"=>"Hardware category successfully updated"], 200);
    }, "updating hardware category");
  }

  public function delete(int $hardwareId) {
    handleControllerRequest(function () use ($hardwareId) {
      $this->hardwareService->delete($hardwareId);
      send_response(true, ["message"=>"Hardware successfully deleted"], 200);
    }, "deleting hardware");
  }

  public function getTotalPrice($userId){
    handleControllerRequest(function () use ($userId) {
      // send_response(true, ["message"=>"Total price successfully obtained", "data"=>$result], 200);
    }, "getting total price");
  }
}
