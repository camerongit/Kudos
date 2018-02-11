<?php
namespace CamHobbs\Kudos\Interfaces;

use \CamHobbs\Kudos\Page\RateLimiter;

interface RateLimited
{
  function getRateLimiter() : RateLimiter;
}
