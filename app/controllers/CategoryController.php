<?php

namespace app\controllers;
use app\database\models\CategoriesModel;

class CategoryController {
  public function __construct(private CategoriesModel $categoriesModel) {}

  public function create() {
    echo "Create category";
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
