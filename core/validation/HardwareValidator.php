<?php

namespace core\validation;
use core\exceptions\ClientException;

class HardwareValidator {
  static public function name(string $name) {
    $regexName = "/^[a-zA-Z0-9]+(?: [a-zA-Z0-9]+)*$/";
    if (!preg_match($regexName, $name) || strlen($name) < 2 || strlen($name) > 200) {
      throw new ClientException("Invalid name. It must be between 2 and 200 characters long and cannot have spaces at the beginning or end.");
    }
  }

  static public function price(string $price) {
    $regexPrice = "/^[0-9., ]{1,10}$/";
    if (!preg_match($regexPrice, $price)) {
      throw new ClientException("Invalid price. It must contain only numbers, '.', ',', and spaces, with a maximum of 10 characters.");
    }
  }
}
