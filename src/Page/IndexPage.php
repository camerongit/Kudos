<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core;

class IndexPage extends Page
{
  private const PAGE_REDIRECT_VALUE = "Home";

  function __construct(Core $core)
  {
    parent::__construct($core->getConfig(), IndexPage::PAGE_REDIRECT_VALUE);
  }

  function view(): void
  {
    $this->display();
  }
}
