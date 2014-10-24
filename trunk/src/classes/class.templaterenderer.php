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

      $html = Utilities::getFileContent($template);
      $html = Utilities::templateReplace($html, $args, static::$var_prefix, static::$var_suffix);
      return $html;
    }

  }
?>