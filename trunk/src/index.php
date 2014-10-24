<?php
  include_once('config.php');
  include_once('classes/class.core.php');
  $core = Core::instance();

  $db = $core->getDb();

  $db->createTable("los_grutos");


  echo $core->render();
?>