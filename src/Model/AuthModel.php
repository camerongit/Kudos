<?php
namespace CamHobbs\Kudos\Model;

class AuthModel extends Model
{
  function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db) {
    parent::__construct($db, "Users", "email");
  }
}
