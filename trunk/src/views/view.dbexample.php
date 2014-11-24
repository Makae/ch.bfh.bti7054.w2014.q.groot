<?php
  class GrootDbexampleView implements IView {

    public function name() {
      return 'dbexample';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletNavi() {
      return array();
    }

    public function viewletFooter() {
      return null;
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    private function exampleUserHandler() {
      $html = "START USER HANDLER <br />";
      // Getting the UserHandler-instance
      $uh = UserHandler::instance();
      // returns true / false
      $uh->login('tony', '12345');
      // get the user from the handler (is a UserModel object)
      $user = $uh->user();
      $html .= " userPrevious: " . $user->getValue('last_name') . '<br />';

      // set new last_name
      $user->setValue('last_name', 'noob');
      // update -> saves the new values to the database
      $user->update();
      $uh->logout();

      // get the new user from the database with the new last_name
      // Here only e proof that it is truly saved in the database
      $user = UserHandler::instance()->login('tony', '12345');
      $user = $uh->user();
      $html .= " userAfter: " . $user->getValue('last_name') . '<br />';
      $html .= "END USER HANDLER <br />";
      return $html;
    }

    public function render() {
      $html = $this->exampleUserHandler();
      return $html;
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>