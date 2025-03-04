<?php
namespace app\services;

use app\database\models\BrandsModel;
use app\database\models\CategoriesModel;
use app\database\models\HardwaresModel;
use core\exceptions\ClientException;
use core\validation\HardwareValidator;

class HardwareService {
  public function __construct(
    public HardwaresModel $hardwareModel, 
    private BrandsModel $brandModel,
    private CategoriesModel $categoryModel 
  ) {}

  public function create(
    string $name, 
    float $price, 
    string $userId,
    ?int $brandId,
    ?int $categoryId
  ) {
    try{ 
      HardwareValidator::name($name);
      HardwareValidator::price($price);
      $this->hardwareModel->insert($name, $price, $userId, $brandId, $categoryId);
      return "Hardware successfully created.";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(int $hardwareId, string $userId) {
    try{ 
      $result = $this->hardwareModel->select($hardwareId, $userId);
      if(empty($result)){
        throw new ClientException("Hardware not found.");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getRelated(int $hardwareId, string $userId) {
    try{ 
      $result = $this->hardwareModel->selectRelated($hardwareId, $userId);
      if(empty($result)){
        throw new ClientException("No related hardware found.");
      }
      return $result;

    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getAllByUserId($userId) {
    try{ 
      $result = $this->hardwareModel->selectAllByUserId($userId);
      if(empty($result)){
        throw new ClientException("No hardware found for this user.");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getAllRelatedByUserId(string $userId) {
    try{ 
      $result = $this->hardwareModel->selectAllRelatedByUserId($userId);
      if(empty($result)){
        throw new ClientException("No related hardware found for this user.");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateName(int $hardwareId, string $newName, string $userId) {
    try {
      HardwareValidator::name($newName);
      $this->hardwareModel->alterName($hardwareId, $newName, $userId);
      return "Hardware name updated successfully.";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function checkHardwareRelated($brand_id, $category_id, $userId) {
    try {
      if (!is_null($brand_id)) {
        if (!filter_var($brand_id, FILTER_VALIDATE_INT)) {
          throw new ClientException("Invalid brand ID. Must be an integer.");
        }
        $brand = $this->brandModel->select($brand_id, $userId);
        if (empty($brand)) {
          throw new ClientException("Brand not found.");
        }
      }

      if (!is_null($category_id)) {
        if (!filter_var($category_id, FILTER_VALIDATE_INT)) {
          throw new ClientException("Invalid category ID. Must be an integer.");
        }
        $category = $this->categoryModel->select($category_id, $userId);
        if (empty($category)) {
          throw new ClientException("Category not found.");
        }
      }

      return "Hardware related successfully.";
    } catch (\Exception $e) {
        throw $e;
    }
}


}