<?php
declare(strict_types=1)
namespace CamHobbs\Kudos\Utils;

use CamHobbs\Kudos\Core\Logger;
use CamHobbs\Kudos\Interfaces\Database;

final class DatabaseConnection
{
  use Logger;

  private $loop;
  private $timer;

  function __construct(\React\EventLoop\StreamSelectLoop $loop)
  {
    $this->loop = $loop;
  }

  function __destruct()
  {
    if($this->timer !== null) {
      $this->loop->cancelTimer($this->timer);
    }
  }

  function keepAlive(Database $database): void
  {
    $this->timer = $this->loop->addPeriodicTimer(30, function () use ($database) {
      if(!$database->isAlive()) {
        $this->log("Attempting to reconnect database.");
        $database->connect();
      }
    });
  }
}
