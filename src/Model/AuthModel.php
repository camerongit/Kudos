<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Model;

use CamHobbs\Kudos\Core\{
  Logger,
  Store
};
use CamHobbs\Kudos\Interfaces\DBEntityIdentifiable;

class AuthModel extends Model implements DBEntityIdentifiable
{
  use Logger;

  protected $idName = "email";
  private $idMap = array();

  private $data = array();
  private $email;

  function __construct(Store $db) {
    parent::__construct($db, "Users");
  }

  function __get($name) {
    if(isset($this->data[$name])) {
      return $this->data[$name];
    }
    return null;
  }

  function saveAsync(callable $successCallback, callable $failCallback)
  {
    (new \React\Promise\Promise(function(callable $resolve, callable $reject) {
      try {
        $this->save();
        $resolve();
      } catch(\Exception $exception) {
        $reject($exception);
      }
    }))->done($successCallback, $failCallback);
  }

  function save(): void
  {
    $data = [
      $this->idName => (string) $this->getId(),
      "password" => (string) $this->password
    ];

    $this->getCollection()->then(function($db) {
      $db->save($data);
      $this->log("Saved data for " + $data[$this->getId()]);
    }, function($errorMsg) {
      $this->log($errorMsg);
    });
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

  function load(): void
  {
    $found = null;

    $this->getCollection()->done(function($db) {
      $found = $db->findOne(array($this->idName => $this->getId()));
      $this->log("Loaded data for " + $found[$this->idName]);
    }, function($errorMsg) {
      $this->log($errorMsg);
    });
    $this->data = $found;
  }

  function setId($id): void
  {
    $this->idMap[$this->idName] = $id;
  }

  function getId()
  {
    return $this->idMap[$this->idName];
  }
}
