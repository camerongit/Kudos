<?php
namespace CamHobbs\Kudos\Core;

class CoreComponent
{
  private $hook;

  protected function __construct(\CamHobbs\Kudos\Core\Core $hook)
  {
    $this->hook = $hook;
  }

  function __set($name, $value)
  {
    switch($name) {
      case "hook":
        echo "Hook should only be set in the constructor of component " . \get_class($this);
        break;
    }
  }

  function __get($name)
  {
    switch($name) {
      case "hook":
        if($this->hook === null) {
          echo "Please make sure Core instance is not null in the constructor of component " . \get_class($this);
        }
        break;
    }
  }
}
