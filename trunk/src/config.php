<?php
  $root_dir = dirname(__FILE__) . '/';
  $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

  // Paths are defined with trailing slashes
  define('ROOT', $root_dir);
  define('WWWROOT', $root_url);
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

  define('TEMPLATE_TMP_DIR', $root_dir . 'theme/templates/tmp/');
  define('TEMPLATE_SALT', 'b7!$.L£4t_');
?>