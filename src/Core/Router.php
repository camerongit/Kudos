<?php
namespace CamHobbs\Kudos\Core;

class Router
{
  private $customRoutes = array();
  private $hook;

  function __construct(\CamHobbs\Kudos\Core\Core $hook)
  {
    $this->hook = $hook;
  }

  function registerCustomRoute(string $route, string $page)
  {
    $this->customRoutes[$route] = $page;
  }

  function listen()
  {
    if(isset($_GET["redirect"])) {
      $redirect = $_GET["redirect"];

      $redirect = \str_replace(\strchr($redirect), "", $redirect);
      $properRedirect = \ucfirst(\strtolower($redirect)) . "Page";

      // Need to match even <something>* paths here..
      if(\array_key_exists($redirect, $this->customRoutes)) {
        if(\array_key_exists("custom_page_directory", $hook->getConfig())) {
          $customPageDir = $hook->getConfig()["custom_page_directory"];

          if($customPageDir !== null) {
            // Check contains include path first, if not.. :
            $page = \get_include_path() . "/" . $customPageDir . "/" . $properRedirect;

            $this->loadPage($page);
          }
        }
      } else {
        $page = "\CamHobbs\Kudos\Page\\" . $properRedirect;
        $this->loadPage($page);
      }
    }
  }

  private function loadPage(string $page)
  {
    if(\get_class($page) !== null) {
      $loadedPage = new $page($this->hook);
      $loadedPage->view();
    }
  }
}
