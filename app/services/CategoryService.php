<?php 

namespace app\services;

use app\database\models\CategoriesModel;
use core\validation\CategoryValidator;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class CategoryService {
  public function __construct(private CategoriesModel $categoriesModel) {}

  public function create(string $name, string $userId) {
    try{ 
      CategoryValidator::name($name);
      $this->categoriesModel->insert($name, $userId);
      return "Category successfully created";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }
    
  
}