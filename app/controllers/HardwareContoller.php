<?php
namespace app\controllers;

use app\database\models\HardwaresModel;

class HardwareContoller {

  public function __construct(private HardwaresModel $hardwareModel) {}

  public function create() {
    echo "POST /hardwares - Create hardware";
  }

  public function get($hardwareId) {
    echo "GET /hardwares/{$hardwareId} - Param: " . $hardwareId;
  }

  public function getRelated($hardwareId) {
    echo "GET /hardwares/related/{$hardwareId} - Param: " . $hardwareId;
  }

  public function getAllByUserId($userId) {
    echo "GET /hardwares/all/{$userId} - Param: " . $userId;
  }

  public function getAllRelatedByUserId($userId) {
    echo "GET /hardwares/all/related/{$userId} - Param: " . $userId;
  }

  public function update($hardwareId) {
    echo "PATCH /hardwares/{$hardwareId} - Update hardware";
  }

  public function updateBrand($hardwareId) {
    echo "PATCH /hardwares/{$hardwareId}/brands - Update brand";
  }

  public function updateCategory($hardwareId) {
    echo "PATCH /hardwares/{$hardwareId}/categories - Update category";
  }

  public function delete($hardwareId) {
    echo "DELETE /hardwares/{$hardwareId} - Delete hardware";
  }
}
