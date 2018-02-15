<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Interfaces;

interface DBEntityIdentifiable
{
  function setId(string $id): void;

  function getId();
}
