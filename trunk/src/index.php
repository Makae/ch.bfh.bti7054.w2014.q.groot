<?php
  include_once('classes/class.core.php');
  $core = Core::instance();
  die(i('my sexy key', array(
    'replace_me' => 'DUE MI ERSETZE'
  )));
  echo $core->render();
?>