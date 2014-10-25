<?php
  include_once('config.php');
  include_once('classes/class.core.php');
  $core = Core::instance();

  require_once('testdata.php');
  echo $core->render();
?>