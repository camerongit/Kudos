<?php
namespace CamHobbs\Kudos\Model;

use CamHobbs\Kudos\Core\DatabaseHandler;
use CamHobbs\Kudos\Interfaces\DBEntity;

abstract class Model implements DBEntity
{
  private $db;
  private $colName;

  protected function __construct(DatabaseHandler $db, $colName)
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
        $resolve($database->$columnName);
      }
    }));
  }
}
