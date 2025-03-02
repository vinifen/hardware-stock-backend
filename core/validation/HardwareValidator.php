<?php

namespace core\validation;
use core\exceptions\ClientException;
use core\exceptions\InternalException;

class HardwareValidator {
  static public function name(string $name) {
    $regexName = "/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/";
    if (!preg_match($regexName, $name) || strlen($name) < 2 || strlen($name) > 200) {
      throw new ClientException("Invalid name. It must be between 2 and 200 characters long and cannot have spaces at the beginning or end.");
    }
  }

  static public function price(float $price) {
    if (!is_float($price)) {
      throw new InternalException("Invalid price. It must be a float.");
    }
  
    $priceString = (string) $price;
  
    if (strlen($priceString) > 10) {
      throw new ClientException("Invalid price. It must be a float with a maximum of 10 characters.");
    }
  }
  
}
