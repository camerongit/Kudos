<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Core;

class Router
{
  private $customRoutes = array();
  private $app;

  function __construct(App $app)
  {
    $this->app = $app;
  }

  function registerCustomPage(string $pageClassLoc): void
  {
    \array_push($this->customRoutes, $pageClassLoc);
  }

  function listen(): void
  {
    if(isset($_GET["redirect"])) {
      $redirect = $_GET["redirect"];

      $redirect = \str_replace(\strchr($redirect, "Page"), "", $redirect);
      $properRedirect = \ucfirst(\strtolower($redirect)) . "Page";

      if(\array_key_exists($redirect, $this->customRoutes) && array_key_exists("custom_page_directory", $this->app->getConfig())) {
        $customPageDir = \str_replace("/", "", $this->app->getConfig()["custom_page_directory"]);

        if($customPageDir !== null) {
          if(!empty(\strchr($customPageDir, \get_include_path()))) {
            $customPageDir = \strchr($customPageDir, \get_include_path());
          }

          $page = \get_include_path() . "/" . $customPageDir . "/" . $properRedirect;

          $this->loadPage($page);
          return;
        }
      } else {
        $page = "\CamHobbs\Kudos\Page\\" . $properRedirect;
        $this->loadPage($page);
        return;
      }
    }
    $page = "\CamHobbs\Kudos\Page\\IndexPage";
    $this->loadPage($page);
  }

  private function loadPage($page): void
  {
    if(\class_exists($page)) {
      $loadedPage = new $page($this->app);
      $loadedPage->view();
    }
  }
}
