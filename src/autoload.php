<?php
// Just for example purposes..

$autoloadFile = __DIR__ . '/../vendor/autoload.php';

if (!is_file($autoloadFile)) {
    die('Please download composer or dump autoloaded files.');
}
require_once $autoloadFile;
