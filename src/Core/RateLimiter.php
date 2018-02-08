<?php
namespace CamHobbs\Kudos\Core;

use CamHobbs\Kudos\Core\Core;

class RateLimiter
{
    private $lastAction;
    protected $timeAllowed = 0;

    function __construct(Core $hook)
    {
      if (!empty($hook->getConfig()['rate_limiter']['time_allowed'])) {
          $this->timeAllowed = $hook->getConfig()['rate_limiter']['time_allowed'];
      }
    }

    protected function setLastAction(time $lastAction)
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
