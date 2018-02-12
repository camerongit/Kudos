<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\App;
use CamHobbs\Kudos\Model\AuthModel;

class LoginPage extends Page
{
  private $rateLimiter;
  private const PAGE_REDIRECT_VALUE = "Login";

  function __construct(App $app)
  {
      parent::__construct($app, LoginPage::PAGE_REDIRECT_VALUE, null);

      $this->setStore(new AuthModel($app->getDB()));
      $this->rateLimiter = new RateLimiter($app->getCache(), "login-" . $_SERVER["REMOTE_ADDR"] . "", 500);
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
