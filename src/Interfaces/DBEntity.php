<?php
namespace CamHobbs\Kudos\Interfaces;

interface DBEntity
{
  function save();

  function load();

  function setId($id);

  function getId();
}
