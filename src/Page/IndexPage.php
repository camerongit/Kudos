<?php
namespace CamHobbs\Kudos\Page;

class IndexPage extends \CamHobbs\Kudos\Page\Page
{
  function __construct(\CamHobbs\Kudos\Core\Core $core)
  {
    parent::__construct($core, "Home");
  }

  function view()
  {
    parent::display();
  }
}
