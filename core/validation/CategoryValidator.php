<?php
namespace core\validation;

use core\exceptions\ClientException;

class CategoryValidator {
  static public function name(string $name) {
    $regexName = "/^[a-zA-Z0-9 ]*$/"; 
    if (strlen($name) > 60 || !preg_match($regexName, $name)) {
      throw new ClientException("Invalid category name. It must be empty or no more than 60 characters long and can only contain letters, numbers, and spaces.");
    }
  }
}
