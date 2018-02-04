<?php
namespace CamHobbs\Kudos\Interfaces;

interface DBEntityIdentifiable extends \CamHobbs\Kudos\Interfaces\DBEntity
{
  function setId($id);

  function getId();
}
