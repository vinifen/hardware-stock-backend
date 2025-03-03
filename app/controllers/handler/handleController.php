<?php

use core\exceptions\ClientException;
use core\exceptions\InternalException;

function handleController(callable $callback, string $contextError){
  try {
    $callback();
  } catch (ClientException $e) {
    error_log($e);
    send_response(false, ["message" => $e->getMessage()], 400); 
  } catch (InternalException $e) {
    error_log($e);
    send_response(false, ["message" => "Internal error " . $contextError], 500); 
  } catch (\Exception $e){
    error_log($e);
    send_response(false, ["message" => "Unexpected error " . $contextError], 500);
  } finally {
    exit;
  }
  
}