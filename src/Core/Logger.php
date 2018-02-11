<?php
namespace CamHobbs\Kudos\Core;

trait Logger
{
  function log(string $text)
  {
    $file = \fopen("dev.log", "a");
    $date = DATE_RFC2822;
    \fwrite($file, \date(\substr($date, 0, \strlen($date) - 2)) . " - " . $text . "\n");
    \fclose($file);
  }
}
