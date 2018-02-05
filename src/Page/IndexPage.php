<?php
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core
use CamHobbs\Kudos\Page\Page;

class IndexPage extends Page
{
  function __construct(\CamHobbs\Kudos\Core\Core $core)
  {
    parent::__construct($core, "Home");
  }

  function view()
  {
    $this->display();
  }
}
