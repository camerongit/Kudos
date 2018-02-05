<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Core\Core;

class DatabaseHandler
{
    private $hook;
    private $config;
    private $db;
    private $databaseName;

    function __construct(Core $hook)
    {
      $this->hook = $hook;
      if(\array_key_exists("db", (array) $hook->getConfig()) && \is_array($hook->getConfig()['db'])) {
        $this->config = $hook->getConfig()['db'];
      }
      $this->databaseName = (isset($this->config["name"])) ? $this->config["name"] : "kudos";
    }

    function isAlive()
    {
      if($this->db === null) {
        return false;
      }
      return true;
    }

    /**
    * Select a collection
    */
    function __get($name)
    {
      if(\property_exists($this, $name)) {
        return $this->$name;
      } else {
        if($this->db !== null) {
          return $this->db->$databaseName->$name;
        } else {
          throw new Exception("Database is not connected yet so cannot access collection $name");
        }
      }
    }

    function connect()
    {
      $host = $this->config['host'];
      $port = $this->config['port'];
      $logger = $this->hook->logger;

      return (new \React\Promise\Promise(function(callable $resolve, callable $reject) use ($host, $port, $logger) {
        $logger->info("Attempting connection to database..");

        try {
          if(isset($host) && isset($port)) {
            $this->db = new \MongoDB\Client("mongodb://" . $host . ":" . $port);
          } else {
            $this->db = new \MongoDB\Client();
          }
          $resolve();
        } catch(\Exception $exception) {
          $reject($exception);
        }
      }));
    }

    function disconnect()
    {
      return (new \React\Promise\Promise(function(callable $resolve, $reject) {
        if($this->db !== null) {
          if(!$this->isAlive()) {
            $resolve("Database connection has already been disconnected.");
          }
          // no method for this??
          //$this->db->close();
          $resolve("Database has been disconnected");
        }
      }));
    }
}
