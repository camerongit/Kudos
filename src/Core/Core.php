<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Interfaces\Database;

class Core
{
    use Logger;

    protected $config = array();
    private $mongo;
    private $cache;
    private $router;

    function __construct()
    {
        $this->mongo = new Store($this);
        $this->cache = new Cache($this);
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
      $this->destroy($this->mongo, "mongo");
      $this->destroy($this->cache, "redis");
    }

    function destroy(Database $handle, $dbPrefix)
    {
      if($handle !== null) {
        $handle->disconnect()->done(function() use ($dbPrefix) {
          $this->log("Disconnected from $dbPrefix db.");
        }, function() use ($dbPrefix) {
          $this->log("Failed to disconnect from $dbPrefix db - (might not be connected?).");
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

    protected function setDB(Store $mongo)
    {
      $this->mongo = $mongo;
    }

    function getDB()
    {
      if($this->mongo !== null) {
        if(!$this->mongo->isAlive()) {
          $this->mongo->connect();
        }
      }
      return $this->mongo;
    }

    function getCache()
    {
      if($this->cache !== null) {
        if(!$this->cache->isAlive()) {
          $this->cache->connect();
        }
      }
      return $this->cache;
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
