<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Interfaces;

interface DBEntity
{
  function save(): void;

  function saveAsync(callable $successCallback, callable $failCallback);

  function load(): void;

  function loadAsync();
}
