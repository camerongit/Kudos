<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Utils;

final class SessionHandler
{
  private function __construct()
  {
  }

  private function __clone()
  {
  }

  static function start()
  {
    \session_start();
  }

  static function setVars($sessionVars, $regenerate = true) {
    foreach($sessionVars as $key => $value) {
      $_SESSION[$key] = $value;
    }
    if($secure) {
      \session_regenerate_id();
    }
  }

  static function destroy()
  {
    if(isset($_SESSION)) {
      \session_destroy();
    }
  }
}
