<?php
  $dir = dirname($_SERVER['SCRIPT_FILENAME']);
  $root_dir = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

  // Paths are defined with trailing slashes
  define('ROOT', $dir . '/');
  define('WWWROOT', $root_dir);
  define('WWWTHEME', WWWROOT . 'theme');
  define('WWWCSS', WWWTHEME . 'css');
  define('WWWJS', WWWTHEME . 'js');

  define('SQL_DEBUGGING', false);
  define('USER_SALT', '!$9*+P/l_o');

  define('DEFAULT_LANGUAGE', 'de');
  define('AVAILABLE_LANGUAGES', 'de,fr,en');


  define('DB_HOST', 'localhost');
  define('DB_USER', 'groot');
  define('DB_PASSWORD', 'groot');
  define('DB_DATABASE', 'groot');
?>