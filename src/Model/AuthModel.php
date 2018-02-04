<?php
namespace CamHobbs\Kudos\Model;

class AuthModel extends \CamHobbs\Kudos\Model\Model
implements \CamHobbs\Kudos\Interfaces\DBEntityIdentifiable
{
  private $idName = "email";
  private $idMap = array();

  private $data = array();
  private $email;

  function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db) {
    parent::__construct($db, "Users");
  }

  function __get($name) {
    if(!\property_exists($name)) {
      return $this->data[$name];
    }
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
    $data = [
      $this->idName => $this->getId(),
      "password" => $this->password;
    ];

    $this->getCollection()->then(function($db) {
      $db->save($data);
    }, function($errorMsg) {
      echo $errorMsg;
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

  function load()
  {
    $found = null;

    $this->getCollection()->done(function($db) {
      $found = $db->findOne($this->idName => $this->getId());
    }, function($errorMsg) {
      echo $errorMsg;
    });
    $this->data = $found;
  }

  function setId($id)
  {
    $this->idMap[$this->idName] = $id;
  }

  function getId()
  {
    return $this->idMap[$this->idName];
  }
}
