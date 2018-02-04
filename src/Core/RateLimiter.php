<?php
namespace CamHobbs\Kudos\Core;

class RateLimiter extends \CamHobbs\Kudos\Core\CoreComponent
{
    private $lastAction;
    protected $timeAllowed = 0;

    function __construct(\CamHobbs\Kudos\Core\Core $hook)
    {
      parent::__construct($hook);

      if (!empty($this->hook->getConfig()['rate_limiter']['time_allowed'])) {
          $this->timeAllowed = $this->hook->getConfig()['rate_limiter']['time_allowed'];
      }
    }

    function __get($name)
    {
        switch ($name) {
        case "latency":
          if ($this->lastAction !== null) {
              return $this->lastAction - time();
          }
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
