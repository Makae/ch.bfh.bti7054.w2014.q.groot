<?php
  /*
    @author: M. Käser
    @date:   25.10.2014
    @desc:   UserHandler manages the login and logout process of the user
  */
  class UserHandler {
    private static $instance;
    // The salt argument is used in the md5-hashing algorithm
    private static $salt = USER_SALT;
    private $user;

    /*
      @desc: singleton constructor. logs the user in automatically,
             if he has its user id in the $_SESSION["user_id"] variable
    */
    private function __construct() {
      if(!isset($_SESSION['user_id'])) {
        $this->user = null;
        return;
      }

      $id = $_SESSION['user_id'];
      $user = new UserModel($id);
    }

    public static function instance() {
      if(static::$instance != null)
        return static::$instance;
      return static::$instance = new UserHandler();
    }

    public function user() {
      return $this->user;
    }


    /*
      @desc: logs the user in, is not necessary if the user_id key
             is already in the session

    */
    public function login($user, $password) {
      $user = UserModel::findFirst(array(
        'user_name' => $user,
        'password' => Utilities::hash($password, static::$salt)
      ));

      if($user == null)
        return false;

      $this->_login($user);

      return true;
    }

    /*
      @desc: register the user, the user is automatically logged in after call
      @todo: In a REAL SHOP there should be a confirmation mail to the user in
             order to verify a real person
      @return: returns the UserModel-Object
    */
    public function register($user_name, $password, $first_name, $last_name) {
      $user = UserModel::create(array(
        'user_name' => $user_name,
        'password' => $password,
        'first_name' => $first_name,
        'last_name' => $last_name
      ));

      $this->_login($user);

      return $user;
    }

    private function _login($user) {
      $this->user = $user;
      $_SESSION['user_id'] = $user->id();
    }

  }
?>