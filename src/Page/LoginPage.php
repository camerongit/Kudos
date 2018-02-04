<?php
namespace CamHobbs\Kudos\Page;

class LoginPage extends Page
{

  function __construct(\CamHobbs\Kudos\Core\Core $hook)
  {
      parent::__construct($hook, "Login");
      $this->setStore(new \CamHobbs\Kudos\Model\AuthModel($hook->getDB()));
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
