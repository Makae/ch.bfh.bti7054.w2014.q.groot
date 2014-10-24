<?php
  $dir = dirname($_SERVER['SCRIPT_FILENAME']);
  $root_dir = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

  define('ROOT', $dir);
  define('WWWROOT', $root_dir);

  define('SQL_DEBUGGING', true);

  define('DB_HOST', 'localhost');
  define('DB_USER', 'groot');
  define('DB_PASSWORD', 'groot');
  define('DB_DATABASE', 'groot');
?>