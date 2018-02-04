<?php
namespace CamHobbs\Kudos\Model;

class AuthModel extends \CamHobbs\Kudos\Model\Model
implements \CamHobbs\Kudos\Interfaces\DBEntityIdentifiable
{
  private $idName;
  private $idMap = array();
  private $email;
  private $password;

  function __construct(\CamHobbs\Kudos\Core\DatabaseHandler $db) {
    parent::__construct($db, "Users", "email");
  }

  function __set($name, $value) {
    if(\property_exists($this, $name)) {
      if($name === "email" || $name === "password") {
        $this->$name = $value;
      }
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
      "email" => $this->email,
      "password" => $this->password,
      $this->idName => $this->getId()
    ];
    $this->getCollection()->save($data);
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
    return $this->getCollection()->findOne($this->idName => $this->getId());
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
