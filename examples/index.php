<?php
\error_reporting(E_ALL);
\ini_set('display_errors', 1);
\set_include_path(__DIR__);

require_once '../src/autoload.php';

$core = \CamHobbs\Kudos\Core\Core::withConfig([
  'rate_limiter' => [
    'time_allowed' => 1000
  ]
]);

$core->getRouter()->listen();
