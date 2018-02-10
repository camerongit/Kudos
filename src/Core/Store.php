<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Interfaces\Database;

class DatabaseHandler extends Database
{
    use Logger;

    protected $prefix = "mongo";
    private $databaseName;

    function __construct(Core $core)
    {
      parent::__construct($core, $this->prefix);
      $this->databaseName = (isset($core->getConfig()[$this->getConfigKey()]["name"])) ? $this->config[$this->getConfigKey()]["name"] : "kudos";
    }

    function __get($name)
    {
      if(\property_exists($this, $name)) {
        return $this->$name;
      } else {
        if($this->db !== null) {
          $dbName = $this->databaseName;
          return $this->db->$dbName->$name;
        } else {
          throw new Exception("Database is not connected yet so cannot access collection $name");
        }
      }
    }

    function connect()
    {
      return parent::connect()->then(function($localhost) {
        try {
          $this->log("Attempting connection to mongo db..");
          if($localhost) {
            $this->db = new \MongoDB\Client;
          } else {
            $this->db = new \MongoDB\Client("mongodb://" . $this->getHost() . ":" . $this->getPort());
          }
          $this->log("Successfully connected to mongo db.");
        } catch(\Exception $e) {
          $this->log("Issue connecting to mongo.. retrying");
        }
      });
    }

    function disconnect()
    {
      return parent::disconnect()->then(function() {
        $this->db = null;
      });
    }
}
