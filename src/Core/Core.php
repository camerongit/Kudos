<?php
namespace CamHobbs\Kudos\Core;

class Core
{
    use Logger;

    protected $config = array();
    private $db;
    private $router;

    function __construct()
    {
        $this->db = new DatabaseHandler($this);
        $this->router = new Router($this);
    }

    static function withConfig(array $options)
    {
        $instance = new self();
        $instance->config = $options;
        return $instance;
    }

    function __destruct()
    {
        if($this->db !== null) {
          $this->db->disconnect()->done(function($result) {
            $this->log($result);
          });
        }
    }

    function setConfig($conf)
    {
      if (\is_array($conf)) {
          $defaultConfig = [];
          $this->config = \array_merge($defaultConfig, $conf);
      }
    }

    function getConfig()
    {
      return $this->config;
    }

    protected function setDB(DatabaseHandler $db)
    {
      $this->db = $db;
    }

    function getDB()
    {
      if($this->db !== null) {
        if(!$this->db->isAlive()) {
          $this->db->connect()->done(function() {
            $this->log("Successfully connected to the database.");
          }, function() {
            $this->log("Failed to connect to the database.");
            // Try and reconnect after a timeout
          });
        }
      }
      return $this->db;
    }

    protected function setRouter(Router $router)
    {
      $this->router = $router;
    }

    function getRouter()
    {
      return $this->router;
    }
}
