<?php
  include_once('config.php');
  include_once('classes/class.core.php');
  $core = Core::instance();

  $db = $core->getDb();


  // $values_assoc = array(
  //   array(
  //   'name' => 'groot1',
  //   'password' => 'we1 are groot',
  //   ),
  //   array(
  //   'name' => 'groot2',
  //   'password' => 'we2 are groot',
  //   ),
  //   array(
  //   'name' => 'groot3',
  //   'password' => 'we3 are groot',
  //   ),
  // );

  // $db->insert('test_table', $values_assoc);

  echo $core->render();
?>