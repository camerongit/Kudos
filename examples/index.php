<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../src/autoload.php';

$core = \CamHobbs\Kudos\Core\Core::withConfig([
  'rate_limiter' => [
    'time_allowed' => 1000
  ]
]);
