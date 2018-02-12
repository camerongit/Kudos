<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Core;

final class AppBuilder
{
  private function __construct()
  {
  }

  private function __clone()
  {
  }

  static function make(?\React\EventLoop\StreamSelectLoop $loop, ?array $config) : App
  {
    return App::withConfig($loop, $config);
  }
}
