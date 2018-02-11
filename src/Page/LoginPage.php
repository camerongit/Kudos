<?php
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core;
use CamHobbs\Kudos\Interfaces\RateLimited;
use CamHobbs\Kudos\Model\AuthModel;

class LoginPage extends Page implements RateLimited
{
  private $rateLimiter;
  private const PAGE_REDIRECT_VALUE = "Login";

  function __construct(Core $core)
  {
      parent::__construct($core->getConfig(), LoginPage::PAGE_REDIRECT_VALUE, null);

      $this->setStore(new AuthModel($core->getDB()));
      $this->rateLimiter = new RateLimiter($core->getCache(), "login-" . $_SERVER["REMOTE_ADDR"] . "", 500);
  }

  function getRateLimiter() : RateLimiter
  {
    return $this->rateLimiter;
  }

  function actionLogin()
  {
    if(isset($_POST["email"]) && isset($_POST["password"])) {
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

      $this->getStore()->setId($email);
      $this->getStore()->load();

      // Compare post password encrypted and targetaccount encrypted pass and if correct..:
      return true;
    }
    return false;
  }

  function view(): void
  {
    $this->display();
  }
}
