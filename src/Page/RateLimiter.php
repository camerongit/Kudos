<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Cache;

class RateLimiter
{
    private $cache;
    protected $prefix;

    private $timeAllowed;

    function __construct(Cache $cache, string $prefix, ?int $timeAllowed) {
      $this->cache = $cache;
      $this->prefix = $prefix;
      $this->timeAllowed = ($timeAllowed === null) ? 500 : $timeAllowed;
    }

    protected function getCache() : Cache
    {
      return $this->cache;
    }

    protected function getTimeAllowed() : string
    {
      return $this->timeAllowed;
    }

    protected function setLastAction(time $lastAction)
    {
      $this->cache->setAndExpire($this->prefix, $lastAction, $this->timeAllowed);
    }

    protected function getLastAction() : ?object
    {
      return $this->cache->getValue($this->prefix);
    }

    function prevent()
    {
        if ($this->getLastAction() === null) {
            $this->setLastAction(\time());
            return false;
        }

        if ((\time() - $this->getLastAction()) <= $this->timeAllowed) {
            return true;
        }
        return false;
    }
}
