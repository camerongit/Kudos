<?php
namespace CamHobbs\Kudos\Core;

class Router
{
  private $customRoutes = array();
  private $hook;

  function __construct(Core $hook)
  {
    $this->hook = $hook;
  }

  function registerCustomPage($page)
  {
    \array_push($this->customRoutes, $page);
  }

  function listen()
  {
    if(isset($_GET["redirect"])) {
      $redirect = $_GET["redirect"];

      $redirect = \str_replace(\strchr($redirect, "Page"), "", $redirect);
      $properRedirect = \ucfirst(\strtolower($redirect)) . "Page";

      if(\array_key_exists($redirect, $this->customRoutes)) {
        if(\array_key_exists("custom_page_directory", $hook->getConfig())) {
          $customPageDir = \str_replace("/", "", $hook->getConfig()["custom_page_directory"]);

          if($customPageDir !== null) {
            if(!empty(\strchr($customPageDir, \get_include_path()))) {
              $customPageDir = \strchr($customPageDir, \get_include_path());
            }

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

  private function loadPage($page)
  {
    if(\class_exists($page)) {
      $loadedPage = new $page($this->hook);
      $loadedPage->view();
    }
  }
}
