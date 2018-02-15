<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\App;
use CamHobbs\Kudos\Model\AuthModel;

class RegisterPage extends Page
{
  private $rateLimiter;
  private const PAGE_REDIRECT_VALUE = "Register";

  function __construct(App $app)
  {
      parent::__construct($app, RegisterPage::PAGE_REDIRECT_VALUE, null);

      $this->setStore(new AuthModel($app->getDB()));
      $this->rateLimiter = new RateLimiter($app->getCache(), "register-" . $_SERVER["REMOTE_ADDR"] . "", ((1000) * 60) * 10);
  }

  function actionRegister(): bool
  {
    if(isset($_POST["email"]) && isset($_POST["password"])) {
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

      if($email) {
        $encryptedPass = \password_hash($_POST["password"], PASSWORD_ARGON2I);
        $this->getStore()->setId($_POST["email"]);

        if($this->getStore()->load() === null) {
          $this->getStore()->password = $encryptedPass;
          $this->getStore()->save();
          return true;
        }
      }
    }
    return false;
  }
}
