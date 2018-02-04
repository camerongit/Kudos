<?php
namespace CamHobbs\Kudos\Core;

class DatabaseHandler extends \CamHobbs\Kudos\Core\CoreComponent
{
    private $config;
    private $db;
    private $databaseName;

    function __construct(\CamHobbs\Kudos\Core\Core $hook)
    {
      parent::__construct($hook);

      if(\array_key_exists("db", (array) $this->hook->getConfig()) && \is_array($this->hook->getConfig()['db'])) {
        $this->config = $this->hook->getConfig()['db'];
      }
      $this->databaseName = (isset($this->config["name"])) ? $this->config["name"] : "kudos";
    }

    function isAlive()
    {
      if($this->db === null) {
        return false;
      }
      // return db connected here..
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

      return (new \React\Promise\Promise(function(callable $resolve, callable $reject) use ($host, $port) {
        echo "Attempting connection to database..";

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
          $this->db->disconnect();
          $resolve("Database has been disconnected");
        }
      }));
    }
}
