<?php
namespace CamHobbs\Kudos\Interfaces;

interface DBEntity
{
  function save();

  function saveAsync();

  function load();

  function loadAsync();
}
