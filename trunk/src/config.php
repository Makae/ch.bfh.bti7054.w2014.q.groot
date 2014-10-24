<?php
  $dir = dirname($_SERVER['SCRIPT_FILENAME']);
  define('ROOT', $dir);
  define('WWWROOT', 'http://localhost/' . basename($dir));

  define('DB_HOST', 'localhost');
  define('DB_USER', 'groot');
  define('DB_PASSWORD', 'groot');
  define('DB_DATABASE', 'groot');
?>