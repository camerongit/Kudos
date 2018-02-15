<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Interfaces;

use CamHobbs\Kudos\Core\App;

class Database
{
  private $host;
  private $port;
  private $configKey;
  protected $db;

  protected function __construct(App $app, string $prefix)
  {
    $this->configKey = $prefix . "_db";

    if(\array_key_exists($this->configKey, (array) $app->getConfig()) && \is_array($app->getConfig()[$this->configKey])) {
      $this->host = $app->getConfig()[$this->configKey]["host"];
      $this->port = $app->getConfig()[$this->configKey]["port"];
    }
  }

  function isAlive(): bool
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

  protected function getConfigKey(): string
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
