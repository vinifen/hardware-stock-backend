<?php

namespace app\controllers;

require_once  base_path() . "/app/controllers/handler/handleController.php";

use app\database\models\CategoriesModel;
use app\services\AuthService;
use app\services\CategoryService;

class CategoryController {
  public function __construct(private CategoryService $categoryService, private AuthService $authService) {}

  public function create() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $body = get_body();

      echo "AQUI EMIM" . var_dump($body) . var_dump($stPayload) ."ASDF";
      $resultHardware = $this->categoryService->create($body["name"], $stPayload->user_id);
      send_response(true, ["message"=>$resultHardware], 201);
    }, "creating hardware");
  }

  public function get($categoriesId) {
    handleController(function () use ($categoriesId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $result = $this->categoryService->get($categoriesId, $stPayload->user_id);

      send_response(true, ["message"=>"Category data successfully obtained.", "data"=>$result], 200);
    }, "getting category.");
  }

  public function getAllByUserId() {
    handleController(function () {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $result = $this->categoryService->getAllByUserId($stPayload->user_id);

      send_response(true, ["message"=>"Category data successfully obtained.", "data"=>$result], 200);
    }, "getting all categories.");
  }

  public function update($categoriesId) {
    handleController(function () use ($categoriesId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);
      $body = get_body();

      $result = $this->categoryService->updateName($categoriesId, $body["name"], $stPayload->user_id);
      send_response(true, ["message"=>$result], 200);
    }, "updating category.");
  }

  public function delete($categoriesId) {
    handleController(function () use ($categoriesId) {
      $stPayload = $this->authService->jwtSessionHandler->decodeToken($_COOKIE["token1"]);

      $this->categoryService->categoriesModel->delete($categoriesId, $stPayload->user_id);
      send_response(true, ["message"=>"Category successfully deleted."], 200);
    }, "deleting category.");
  }
}
