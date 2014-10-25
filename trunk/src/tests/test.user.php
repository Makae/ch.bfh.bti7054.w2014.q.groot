<?php

  class Test_User  extends BaseTest {
    private $db = null;

    public function prepare() {
      $cwd = getcwd();
      chdir('..');
      require_once('config.php');
      require_once('classes/class.core.php');
      require_once('testdata.php');

      // prevent chdir problems
      $core = Core::instance();
      chdir($cwd);
    }

    public function testLogin() {
      $ok = UserHandler::instance()->login('tony', '12345');
      $user = UserHandler::instance()->user();
      $this->equal($ok, true, 'Could not login user');
      $this->equal($user->getValue('user_name'), 'tony', 'not the right user');
      $this->notEqual($user->getValue('password'), '12345', 'password is not hashed');
    }

  }
?>