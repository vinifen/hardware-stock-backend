<?php

namespace app\controllers;
use app\database\models\CategoriesModel;
use app\services\AuthService;
use app\services\CategoryService;

class CategoryController {
  public function __construct(private CategoryService $categoryService, private AuthService $authService) {}

  
  //arrumar aqui
  public function create($userId) {
    echo "AQUI EMIM" . var_dump($userId) ."ASDF";
    handleControllerRequest(function () use ($userId) {
      
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
