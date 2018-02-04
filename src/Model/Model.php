<?php
namespace CamHobbs\Kudos\Model;

abstract class Model implements \CamHobbs\Kudos\Interfaces\DBEntity
{
  private $db;
  private $colName;

  protected function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db, string $colName)
  {
    $this->db = $db;
    $this->colName = $colName;
  }

  protected function getCollection()
  {
    $database = $this->db;
    $columnName = $this->columnName;

    return (new \React\Promise\Promise(function(callable $resolve, callable $reject) use ($database, $columnName) {
      if($db->isAlive()) {
        $reject("Database is not connected. Please try again later.");
      } else {
        $resolve($db->$colName);
      }
    }));
  }
}
