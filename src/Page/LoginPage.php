<?php
declare(strict_types=1);
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\App;
use CamHobbs\Kudos\Core\RateLimiter;
use CamHobbs\Kudos\Model\AuthModel;
use CamHobbs\Kudos\Utils\SessionHandler;

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

  function actionLogin(): bool
  {
    if(isset($_POST["email"]) && isset($_POST["password"])) {
      $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

      if($email) {
        $this->getStore()->setId($_POST["email"]);
        $data = $this->getStore()->load();

        if($data !== null && \array_key_exists("encryptedPass", $data)) {
          $encrypted = $data["encryptedPass"];

          if(\password_verify($_POST["password"], $encrypted)) {
            SessionHandler::start();
            SessionHandler::setVars(array(
              "csrfToken" => \bin2hex(\random_bytes(32)),
              "userId" => $_POST["email"]
            ), false);
            return true;
          }
        }
      }
    }
    return false;
  }

  function view(): void
  {
    $this->display();
  }
}
