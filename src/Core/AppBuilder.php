<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Core;

class AppBuilder
{
  private function __construct()
  {
  }

  private function __clone()
  {
  }
  
  static function make(?array $config) : App
  {
    return App::withConfig($config);
  }
}
