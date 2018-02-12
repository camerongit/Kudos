<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\App;

class IndexPage extends Page
{
  private const PAGE_REDIRECT_VALUE = "Home";

  function __construct(App $app)
  {
    parent::__construct($app, IndexPage::PAGE_REDIRECT_VALUE, null);
  }

  function view(): void
  {
    $this->display();
  }
}
