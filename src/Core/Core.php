<?php
namespace CamHobbs\Kudos\Core;

class Core
{
    private $rateLimiter;
    protected $config;
    private $db;
    private $router;

    function __construct()
    {
        $this->rateLimiter = new \CamHobbs\Kudos\Core\RateLimiter($this);
        $this->db = new \CamHobbs\Kudos\Core\DatabaseHandler($this);
        $this->router = new \CamHobbs\Kudos\Core\Router($this);
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
            echo $result;
          });
        }
    }

    function __set($key, $value)
    {
        switch ($key) {
        case "config":
          if (\is_array($value)) {
              $defaultConfig = [];
              $this->config = \array_merge($defaultConfig, $value);
          }
          break;
      }
    }

    function getConfig()
    {
      return $this->config;
    }

    protected function setRateLimiter(\CamHobbs\Kudos\Core\RateLimiter $rateLimiter)
    {
      $this->rateLimiter = $rateLimiter;
    }

    protected function getRateLimiter()
    {
      return $this->rateLimiter;
    }

    protected function setDB(\CamHobbs\Kudos\Core\DatabaseHandler $db)
    {
      $this->db = $db;
    }

    function getDB()
    {
      if($this->db !== null) {
        if(!$this->db->isAlive()) {
          $this->db->connect()->done(function() {
            echo "Successfully connected to the database.";
          }, function() use ($connection) {
            echo "Failed to connect to the database.";
            // Try and reconnect after a timeout
          });
        }
      }
      return $this->db;
    }

    protected function setRouter(\CamHobbs\Kudos\Core\Router $router)
    {
      $this->router = $router;
    }

    function getRouter()
    {
      return $this->router;
    }
}
