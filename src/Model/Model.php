<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Model;

use CamHobbs\Kudos\Core\Store;
use CamHobbs\Kudos\Interfaces\DBEntity;

abstract class Model implements DBEntity
{
  private $mongo;
  private $colName;

  protected function __construct(Store $mongo, string $colName)
  {
    $this->mongo = $mongo;
    $this->colName = $colName;
  }

  protected function getCollection()
  {
    $database = $this->mongo;
    $columnName = $this->columnName;

    return (new \React\Promise\Promise(function(callable $resolve, callable $reject) use ($database, $columnName) {
      if($database->isAlive()) {
        $reject("Database is not connected. Please try again later.");
      } else {
        $resolve($database->$columnName);
      }
    }));
  }
}
