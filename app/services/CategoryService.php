<?php 
namespace app\services;

use app\database\models\CategoriesModel;
use core\validation\CategoryValidator;
use core\exceptions\ClientException;

class CategoryService {
  public function __construct(public CategoriesModel $categoriesModel) {}

  public function create(string $name, string $userId) {
    try{ 
      CategoryValidator::name($name);
      $this->categoriesModel->insert($name, $userId);
      return "Category successfully created";
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get(int $categoryId, string $userId) {
    try{ 
      $result = $this->categoriesModel->select($categoryId, $userId);
      if(empty($result)){
        throw new ClientException("Category not found");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }
    
  public function getAllByUserId($userId) {
    try{ 
      $result = $this->categoriesModel->selectAllUserId($userId);
      if(empty($result)){
        throw new ClientException("No category found for this user");
      }
      return $result;
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateName(int $categoryId, string $name, string $userId) {
    try{ 
      CategoryValidator::name($name);
      $this->categoriesModel->alter($categoryId, $name, $userId);
      return "Category successfully updated";
    } catch (\Exception $e){
      throw $e;
    }
  }
  
}