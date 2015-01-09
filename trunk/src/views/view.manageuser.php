<?php
  class GrootManageuserView implements IView {

    public function name() {
      return 'manageuser';
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

    public function render() {
      // Here comes the rendering process
return '
<div id="content">
          <h1>Benutzerverwaltung</h1>
      <p>
      <div class="profil">
        <div class="picture"><img  src="theme/images/user.png" height="80" width="80" />
        </div>
        <div class="settings">
          <p><div class="label1 column1" >'.i("id").':</div><input class="column1 input1" value="Hansruedi" name="prename" /></p>
          <p><div class="label1 column1" >'.i("User").':</div><input class="column1 input1" value="Geissler" name="12" /></p>
          <p><div class="label1 column1" >'.i("first_name").':</div><input class="column1 input1" value="Steinisbruggweg 23" name="231" /></p>
          <p><div class="label1 column1" >'.i("last_name").':</div><input class="column1 input1" value="Hilterfingen" name="142" /></p>
          <p><div class="label1 column1" >'.i("Password").':</div><input class="column1 input1" value="2401" name="521" /></p>
          <p><div class="label1 column1" >'.i("Sprache").':</div><select class="column1 input1" name="language" size="1">
      <option value="DE">Deutsch</option>
      <option value="EN">English</option>
    </select></p>
          <p><div class="label1 column1" >'.i("isAdmin").':</div><input class="column1 input1" type="checkbox" name="checkbox" value="value"></p>
        </div>
      </div>
        </div>
';
  #  return =  Here will be the profile render soon ... ";
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>