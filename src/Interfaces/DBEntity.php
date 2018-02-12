<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Interfaces;

interface DBEntity
{
  function save();

  function saveAsync(callable $successCallback, callable $failCallback);

  function load();

  function loadAsync();
}
