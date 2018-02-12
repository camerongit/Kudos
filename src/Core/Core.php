<?php
declare(strict_types=1);
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

    static function withConfig(?array $options): Core
    {
        $instance = new static();
        $instance->setConfig($options);
        return $instance;
    }

    function __destruct()
    {
      $this->destroy($this->mongo, "mongo");
      $this->destroy($this->cache, "redis");
    }

    private function destroy(Database $handle, string $dbPrefix): void
    {
      if($handle !== null) {
        $handle->disconnect()->done(function() use ($dbPrefix) {
          $this->log("Disconnected from $dbPrefix db.");
        }, function() use ($dbPrefix) {
          $this->log("Failed to disconnect from $dbPrefix db - (might not be connected?).");
        });
      }
    }

    function setConfig(?array $conf): void
    {
      $defaultConfig = [];

      if ($conf !== null && \is_array($conf)) {
          $this->config = \array_merge($defaultConfig, $conf);
      } else {
        $this->defaultConfig = $conf;
      }
    }

    function getConfig(): array
    {
      return $this->config;
    }

    protected function setDB(Store $mongo): void
    {
      $this->mongo = $mongo;
    }

    function getDB(): Store
    {
      if($this->mongo !== null) {
        if(!$this->mongo->isAlive()) {
          $this->mongo->connect();
        }
      }
      return $this->mongo;
    }

    function getCache(): Cache
    {
      if($this->cache !== null) {
        if(!$this->cache->isAlive()) {
          $this->cache->connect();
        }
      }
      return $this->cache;
    }

    protected function setRouter(Router $router): void
    {
      $this->router = $router;
    }

    function getRouter(): Router
    {
      return $this->router;
    }
}
