<?php
namespace CamHobbs\Kudos\Model;

class Model implements \CamHobbs\Kudos\Interfaces\DBEntity
{
  private $collection;
  private $idName;
  private $idMap = array();

  protected function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db, $colName, $idName)
  {
    $this->collection = $db->$colName;
    $this->idName = $id;
    \array_push($this->idMap, array($this->idName => ""));
  }

  function loadAsync()
  {
    return new \React\Promise\Promise(function(callable $resolve, callable $reject) {
      try {
        $resolve($this->load());
      } catch(\Exception $exception) {
        $reject($exception);
      }
    });
  }

  function load()
  {
    // Load using id
  }

  function saveAsync(callable $successCallback, callable $failCallback)
  {
    new \React\Promise\Promise(function(callable $resolve, callable $reject) {
      try {
        $this->save();
        $resolve();
      } catch(\Exception $exception) {
        $reject($exception);
      }
    })->done($successCallback, $failCallback);
  }

  function save()
  {
    // Save using id, cast to prevent injection remember
  }

  function setId($id)
  {
    $this->idMap[$this->idName] = $id;
  }

  function getId()
  {
    return $this->id;
  }
}
