<?php
namespace core\config;

class Variables {
 
  public static function DB_HOST() {
    return self::getEnvVar("DB_HOST");
  }

  public static function DB_USER() {
    return self::getEnvVar("DB_USER");
  }

  public static function DB_PASSWORD() {
    return self::getEnvVar("DB_PASSWORD");
  }

  public static function DB_NAME() {
    return self::getEnvVar("DB_NAME");
  }

  public static function DB_PORT() {
    return self::getEnvVar("DB_PORT");
  }


  public static function ALLOWED_ORIGIN() {
    return self::getEnvVar("ALLOWED_ORIGIN");
  }


  public static function JWT_SESSION_KEY() {
    return self::getEnvVar("JWT_SESSION_KEY");
  }

  public static function JWT_REFRESH_KEY() {
    return self::getEnvVar("JWT_REFRESH_KEY");
  }


  public static function cookie_http_only() {
    return true;
  }

  public static function cookie_secure() {
    return false;
  }

  


  private static function getEnvVar($key) {
    if (!isset($_ENV[$key]) || empty($_ENV[$key])) {
      throw new \Exception("Variable $key is not set or is empty in the .env file");
    }
    return $_ENV[$key];
  }
}
