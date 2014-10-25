<?php
  $db = Core::instance()->getDb();
  if(isset($_REQUEST['clear_tables']) && $_REQUEST['clear_tables'] == true) {
    $db->drop('user');
  }

  if(!$db->tableExists('user')) {
    UserModel::create(array(
      'user_name' => 'tony',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Tony',
      'last_name' => 'Stark',
      'lang' => 'de'
    ));
    UserModel::create(array(
      'user_name' => 'hulk',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Bruce',
      'last_name' => 'Banner',
      'lang' => 'de'
    ));
    UserModel::create(array(
      'user_name' => 'thor',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Thor',
      'last_name' => 'Odinsson',
      'lang' => 'de'
    ));
  }
?>