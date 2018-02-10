<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Interfaces\Database;

class Cache extends Database
{
  use Logger;

  function __construct($core)
  {
    parent::__construct($core, "redis");
  }

  function cache($key, $value, $time)
  {
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
