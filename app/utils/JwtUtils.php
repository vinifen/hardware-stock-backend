<?php
namespace app\utils;

use Ramsey\Uuid\Uuid;

class JwtUtils {
    
  public static function generateSessionPayload($data = [], $expiration = null): array {
    $expiration = $expiration ?? self::sessionExpiration();
    $stUuid = Uuid::uuid7(); 
    $finalPayload = array_merge(
      [
        "token_id" => $stUuid,
        'exp' => $expiration
      ],
      $data
    );

    return $finalPayload;
  }

  public static function generateRefreshPayload($data = [], $expiration = null): array {
    $expiration = $expiration ?? self::refreshExpiration();
    $rtUuid = Uuid::uuid7(); 
    $finalPayload = array_merge(
      [
        "token_id" => $rtUuid,
        'exp' => $expiration
      ],
      $data
    );

    return $finalPayload;
  }

  public static function generatePayloads(array $userData, $payload = []): array {
    $sessionPayload = self::generateSessionPayload($userData, $payload);
    $refreshPayload = self::generateRefreshPayload($userData, $payload);

    return [
      'sessionPayload' => $sessionPayload,
      'refreshPayload' => $refreshPayload,
    ];
  }

  public static function refreshExpiration(){
    return (time() + (86400 * 7));
  }

  public static function sessionExpiration(){
    return (time() + (86400 * 2 / 24));
  }
}
