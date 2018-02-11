<?php
namespace CamHobbs\Kudos\Interfaces;

use CamHobbs\Kudos\Core\Core;

class Database
{
  private $host;
  private $port;
  private $configKey;
  protected $db;

  protected function __construct(Core $core, string $prefix)
  {
    $this->configKey = $prefix . "_db";

    if(\array_key_exists($this->configKey, (array) $core->getConfig()) && \is_array($core->getConfig()[$this->configKey])) {
      $this->host = $core->getConfig()[$this->configKey]["host"];
      $this->port = $core->getConfig()[$this->configKey]["port"];
    }
  }

  function isAlive()
  {
    return $this->db !== null;
  }

  function connect()
  {
    return (new \React\Promise\Promise(function(callable $resolve, callable $reject) {
      $resolve(!(isset($this->host) && isset($this->port)));
    }));
  }

  function disconnect()
  {
    return (new \React\Promise\Promise(function(callable $resolve, $reject) {
      if(!$this->isAlive()) {
        $reject();
      } else {
        $resolve();
      }
    }));
  }

  protected function getConfigKey()
  {
    return $this->configKey;
  }

  protected function getHost(): ?string
  {
    return $this->host;
  }

  protected function getPort(): ?string
  {
    return $this->port;
  }
}
