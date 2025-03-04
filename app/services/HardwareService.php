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

  public function checkHardwareRelated(?int $brand_id, ?int $category_id, string $userId) {
    try {
      
      if(!empty($brand_id)){ 
        $brand = $this->brandModel->select($brand_id, $userId);
        if(empty($brand)){
          throw new ClientException("Brand not found.");
        }
      }
      if(!empty($category_id)){
        $category = $this->categoryModel->select($category_id, $userId);
        if(empty($category)){
          throw new ClientException("Category not found.");
        }
      }
      return "Hardware related successfully.";
    } catch (\Exception $e) {
      throw $e;
    }
  }

  // public function updateBrand($hardwareId, $brandId, $userId) {
  //   try{
  //     $this->hardwareModel->alterBrandId($hardwareId, $brandId, $userId);
  //     return "Hardware brand updated successfully";
  //   } catch (\Exception $e){
  //     throw $e;
  //   }
  // }

  // public function updateCategory(int $hardwareId, $categoryId) {
  //   try{
  //     $this->hardwareModel->alterCategoryId($hardwareId, $categoryId);
  //     return "Hardware category updated successfully";
  //   } catch (ClientException | InternalException $e) {
  //     throw $e; 
  //   } catch (\Exception $e){
  //     throw $e;
  //   }
  // }

  // public function getFullPrice($userId){
  //   try{
  //     $result = $this->hardwareModel->selectTotalPrice($userId);
  //     if(empty($result)){
  //       throw new ClientException("No hardware prices found for this user");
  //     }
  //     return $result;
  //   } catch (ClientException | InternalException $e) {
  //     throw $e; 
  //   } catch (\Exception $e){
  //     throw $e;
  //   }
  // }

  // public function delete($hardwareId) {
  //   try{ 
  //     $this->hardwareModel->delete($hardwareId);
  //     return "Hardware deleted successfully";
  //   } catch (ClientException | InternalException $e) {
  //     throw $e; 
  //   } catch (\Exception $e){
  //     throw $e;
  //   }
  // }
}