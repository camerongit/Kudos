<?php
namespace CamHobbs\Kudos\Model;

class Model {

  private $collection;

  protected function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db, $colName)
  {
    $this->collection = $db->$colName;
  }

  protected function load()
  {
  }

  protected function save()
  {
  }
}
