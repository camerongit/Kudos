<?php
namespace CamHobbs\Kudos\Model;

class Model
{
  private $collection;

  protected function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db, $colName, $idName)
  {
    $this->collection = $db->$colName;
    $this->idName = $id;
    \array_push($this->idMap, array($this->idName => ""));
  }

  protected function getCollection()
  {
    return $this->collection;
  }
}
