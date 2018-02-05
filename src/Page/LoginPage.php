<?php
namespace CamHobbs\Kudos\Page;

use CamHobbs\Kudos\Core\Core;
use CamHobbs\Kudos\Model\AuthModel;

class LoginPage extends Page
{
  function __construct(Core $hook)
  {
      parent::__construct($hook, "Login");
      $this->setStore(new AuthModel($hook->getDB()));
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

  function view() {
    $this->display();
  }
}
