<?php
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core;

class IndexPage extends Page
{
  function __construct(Core $core)
  {
    parent::__construct($core->getConfig(), "Home");
  }

  function view()
  {
    $this->display();
  }
}
