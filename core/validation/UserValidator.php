<?php
namespace core\validation;

use Exception;

class UserValidator{
  static public function username(string $username){
    $regexUsername = "/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/";
    if (!preg_match($regexUsername, $username) || strlen($username) < 2 || strlen($username) > 50) {
      throw new Exception("Invalid username. It must be between 2 and 50 characters long and cannot have spaces at the beginning or end.");
    }
    return true;
  }

  static public function password(string $password){
    $regexPassword = "/^[^\s]{6,60}$/";
    if(!preg_match($regexPassword, $password)){
      throw new Exception("Invalid password. It must be between 6 and 60 characters long and cannot contain spaces.");
    }
    return false;
  }
}