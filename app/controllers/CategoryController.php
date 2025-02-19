<?php

namespace app\controllers;
use app\database\models\CategoriesModel;
use app\services\AuthService;
use app\services\CategoryService;

class CategoryController {
  public function __construct(private CategoryService $categoryService, private AuthService $authService) {}

  public function create($publicUserId) {
    echo "AQUI EMIM" . var_dump($publicUserId) ."ASDF";
    handleControllerRequest(function () use ($publicUserId) {
      $resultAuth = $this->authService->verifyUser($publicUserId);
      $userId = $resultAuth["id"];
      $body = get_body();
      echo "AQUI EMIM" . var_dump($body) ."ASDF";
      $resultHardware = $this->categoryService->create($body["name"], $userId);
      send_response(true, ["message"=>$resultHardware], 201);
    }, "creating hardware");
  }

  public function get($categoriesId) {
    echo "Fetch category: " . $categoriesId;
  }

  public function getAllByUserId($userId) {
    echo "Fetch all categories for user: " . $userId;
  }

  public function update($categoriesId) {
    echo "Update category: " . $categoriesId;
  }

  public function delete($categoriesId) {
    echo "Delete category: " . $categoriesId;
  }
}
