<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Interfaces\Database;

class Cache extends Database
{
  use Logger;
  private const DB_PREFIX = "redis";

  function __construct(App $app)
  {
    parent::__construct($app, Cache::DB_PREFIX);
  }

  function isAlive(): bool
  {
    return parent::isAlive() && $this->db->isConnected();
  }

  function setAndExpire(string $key, $value, int $timeMs): void
  {
    if($this->isAlive()) {
      $this->db->set($key, $value);
      $this->db->expire($key, $timeMs);
    }
  }

  function getValue($key) : ?object
  {
    if($this->isAlive()) {
      return $this->db->get($key);
    }
    return null;
  }

  function connect()
  {
    return parent::connect()->then(function($localhost) {
      $this->log("Attempting to connect to redis db.. (cache)");
      try {
        if($localhost) {
          $this->db = new \Predis\Client;
        } else {
          $this->db = new \Predis\Client(array(
            "scheme" => "tcp",
            "host" => $this->getHost(),
            "port" => $this->getPort()
          ));
        }
        $this->log("Successfully connected to redis db.. (cache)");
      } catch(\Exception $e) {
        $this->log("Issue connecting to redis");
      }
    });
  }

  function disconnect()
  {
    return parent::disconnect()->then(function() {
      $this->db->disconnect();
      $this->db = null;
    });
  }
}
