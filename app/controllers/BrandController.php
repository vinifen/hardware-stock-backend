<?php

namespace app\controllers;

use app\database\models\BrandsModel;

class BrandController {
  public function __construct(private BrandsModel $brandModel) {}

  public function create() {
    echo "Creating a new brand.";
  }

  public function get($brandsId) {
    echo "Fetching brand with ID: $brandsId";
  }

  public function getAllByUserId($userId) {
    echo "Fetching all brands for user ID: $userId";
  }

  public function update($brandsId) {
    echo "Updating brand with ID: $brandsId";
  }

  public function delete($brandsId) {
    echo "Deleting brand with ID: $brandsId";
  }
}
