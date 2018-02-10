<?php
namespace CamHobbs\Kudos\Page;

// Ignore for the time being, this needs to use redis as a cache.
class RateLimiter
{
    private $lastAction;
    protected $timeAllowed = 0;

    function setTimeAllowed($timeAllowed)
    {
      $this->timeAllowed = $timeAllowed;
    }

    protected function getTimeAllowed()
    {
      return $this->timeAllowed;
    }

    function setLastAction(time $lastAction)
    {
      $this->lastAction = $lastAction;
    }

    protected function getLastAction()
    {
      return $this->lastAction;
    }

    function prevent()
    {
        if ($this->lastAction === null) {
            $this->lastAction = time();
            return false;
        }

        if ($this->latency <= $this->timeAllowed) {
            return true;
        }
        return false;
    }
}