<?php 
namespace app\services;

use app\database\models\BrandsModel;
use core\validation\BrandValidator;
use core\exceptions\ClientException;

class BrandService {
  public function __construct(public BrandsModel $brandModel) {}

  public function create(string $name, string $userId) {
    try{ 
      BrandValidator::name($name);
      $this->brandModel->insert($name, $userId);
      return "Brand successfully created";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(int $brandId, string $userId) {
    try{ 
      $result = $this->brandModel->select($brandId, $userId);
      if(empty($result)){
        throw new ClientException("Brand not found");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getAllByUserId($userId) {
    try{ 
      $result = $this->brandModel->selectAllUserId($userId);
      if(empty($result)){
        throw new ClientException("No brand found for this user");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateName(int $brandId, string $newName, string $userId) {
    try {
      BrandValidator::name($newName);
      $result = $this->brandModel->alter($brandId, $newName, $userId);
      if(empty($result)){
        throw new ClientException("Brand not found");
      }
      return "Brand name successfully updated";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function remove(int $brandId, string $userId) {
    try {
      $result = $this->brandModel->delete($brandId, $userId);
      if(empty($result)){
        throw new ClientException("Brand not found");
      }
      return "Brand successfully deleted";
    } catch (\Exception $e){
      throw $e;
    }
  }
}