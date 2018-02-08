<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Core\RateLimiter;
use CamHobbs\Kudos\Core\DatabaseHandler;
use CamHobbs\Kudos\Core\Router;

class Core
{
    private $rateLimiter;
    protected $config = array();
    private $db;
    private $router;
    protected $logger;

    function __construct()
    {
        $this->rateLimiter = new RateLimiter($this);
        $this->db = new DatabaseHandler($this);
        $this->router = new Router($this);

        if($this->config !== null && \array_key_exists("logger_path", $this->config)) {
          $this->logger = new \Monolog\Logger('dev');
          $this->logger->pushHandler(new \Monolog\Handler\StreamHandler($this->config["logger_path"], \MonoLog\Logger::INFO));
        } else {
          $this->logger = new \Monolog\Logger('dev');
          $this->logger->pushHandler(new \Monolog\Handler\StreamHandler("dev.log", \MonoLog\Logger::INFO));
        }
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
            $this->logger->info($result);
          });
        }
    }

    function getLogger()
    {
      return $this->logger;
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

    protected function setRateLimiter(RateLimiter $rateLimiter)
    {
      $this->rateLimiter = $rateLimiter;
    }

    protected function getRateLimiter()
    {
      return $this->rateLimiter;
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
            $this->logger->info("Successfully connected to the database.");
          }, function() {
            $this->logger->error("Failed to connect to the database.");
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
