<?php
namespace app\services;

use app\database\models\HardwaresModel;
use app\database\models\UsersModel;
use core\exceptions\ClientException;
use core\exceptions\InternalException;
use core\validation\HardwareValidator;

class HardwareService {
  public function __construct(private HardwaresModel $hardwareModel) {}

  public function create(
    string $name, 
    float $price, 
    int $userId = null,
    int $brandId = null,
    int $categoryId = null
  ) {
    try{ 
      HardwareValidator::name($name);
      HardwareValidator::price($price);
      $this->hardwareModel->insert($name, $price, $userId, $brandId, $categoryId);
      return "Hardware successfully created";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function get($hardwareId) {
    try{ 
      $result = $this->hardwareModel->select($hardwareId);
      if(empty($result)){
        throw new ClientException("Hardware not found");
      }
      return $result;
      echo "GET HARDWARE SERVICE ok";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getRelated($hardwareId) {
    echo "GET /hardwares/related/{$hardwareId} - Param: " . $hardwareId;
  }

  public function getAllByUserId($userId) {
    try{ 
      $result = $this->hardwareModel->selectAllByUserId($userId);
      if(empty($result)){
        throw new ClientException("No hardware found for this user");
      }
      return $result;
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getAllRelatedByUserId(int $userId) {
    try{ 
      $result = $this->hardwareModel->selectAllRelatedByUserId($userId);
      if(empty($result)){
        throw new ClientException("No related hardware found for this user");
      }
      return $result;
      echo "GET ALL RELATED HARDWARE SERVICE ok";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateName($hardwareId, $newName) {
    try {
      HardwareValidator::name($newName);
      $this->hardwareModel->alterName($hardwareId, $newName);
      return "Hardware name updated successfully";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateBrand($hardwareId, $brandId) {
    try{
      $this->hardwareModel->alterBrandId($hardwareId, $brandId);
      return "Hardware brand updated successfully";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function updateCategory(int $hardwareId, $categoryId) {
    try{
      $this->hardwareModel->alterCategoryId($hardwareId, $categoryId);
      return "Hardware category updated successfully";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function getFullPrice($userId){
    try{
      $result = $this->hardwareModel->selectTotalPrice($userId);
      if(empty($result)){
        throw new ClientException("No hardware prices found for this user");
      }
      return $result;
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }

  public function delete($hardwareId) {
    try{ 
      $this->hardwareModel->delete($hardwareId);
      return "Hardware deleted successfully";
    } catch (ClientException | InternalException $e) {
      throw $e; 
    } catch (\Exception $e){
      throw $e;
    }
  }
}