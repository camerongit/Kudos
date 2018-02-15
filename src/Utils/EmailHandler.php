<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Utils;

final class EmailHandler
{
  private static $instance;

  private function __construct()
  {
  }

  private function __clone()
  {
  }

  static function get()
  {
    return self::$instance === null ? new self() : self::$instance;
  }
}
