<?php
  class TemplateRenderer {
    private static $instance = null;
    private static $var_prefix = '{%';
    private static $var_suffix = '%}';

    private function __construct() {
    }

    public function instance() {
      if(self::$instance != null)
        return self::$instance;
      return self::$instance = new TemplateRenderer();
    }

    public function render($template, $args) {
      if(!file_exists($template))
        throw new Exception('The template "' . $template . '" does not exist');
      $fh = fopen($template, 'r');
      $html = fread($fh, filesize($template));

      foreach($args as $key => $value)
        $html = str_ireplace($this->varIt($key), $value, $html);
      fclose($fh);
      return $html;
    }

    private function varIt($key) {
      return static::$var_prefix . $key . static::$var_suffix;
    }

  }
?>