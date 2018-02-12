<?php
\error_reporting(E_ALL);
\ini_set('display_errors', 1);
\set_include_path(__DIR__);
\date_default_timezone_set("GMT");

require_once '../src/autoload.php';

$loop = \React\EventLoop\Factory::create();

$app = \CamHobbs\Kudos\Core\AppBuilder::make($loop, null);

$app->getRouter()->listen();
$loop->run();
