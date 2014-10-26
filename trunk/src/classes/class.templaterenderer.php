<?php
  class TemplateRenderer {
    private static $instance = null;
    private static $var_prefix = '{%';
    private static $var_suffix = '%}';
    private static $tmp_dir = 'TR_TEMP';
    private static $salt = TEMPLATE_SALT;

    private function __construct() {
    }

    public function setTplDir($dir) {
      $dir = realpath($dir);
      if(!file_exists($dir) || !is_dir($dir))
        throw new Exception("This folder $dir does not exist!");

      TemplateRenderer::$tmp_dir = $dir;
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

    public function extendedRender($template, $args) {
      $html = Utilities::getFileContent($template);

      $tpl_php = $this->_prepareFors($html);
      $tpl_php = $this->_prepareIfs($tpl_php);
      $tpl_php = $this->_prepareVariables($tpl_php, $args);

      return $this->_templateInclude($template, $tpl_php, $args);
    }

    private function _templateInclude($template, $html, $args) {
      $tmp_path = static::$tmp_dir . '/tmp.' . basename($template). '.' . Utilities::hash($template, static::$salt) . '.php';

      $fh = fopen($tmp_path, 'w');
      fwrite($fh, $html);

      extract($args);
      ob_start();
      require_once($tmp_path);
      $html = ob_get_clean();
      return $html;
    }

    private function _prepareVariables($html) {
      $html = preg_replace('/\{(\$[^\}]*)\}/mi', '<?php if(isset($1)) echo $1;?>', $html);
      $html = preg_replace('/(\$[a-zA-Z0-9_]+)(\.)([a-zA-Z0-9_]+)/mi', '$1[\'$3\']', $html);
      return $html;
    }

    private function _prepareIfs($html) {
      $matches = array();
      preg_match_all('/\{\/?if[^\}]*}/mi', $html, $matches, PREG_OFFSET_CAPTURE);

      if(count($matches[0]) % 2 != 0)
        throw new Exception("Template $template has no matching if tags count");

      $depth = 0;
      $len_diff = 0;
      $matches = $matches[0];
      foreach($matches as $match) {
        $match_str = $match[0];
        $match_len = $match[1];
        // is {for}
        if(!preg_match('/\{\/if[^\}]*/i', $match_str)) {
          $depth++;
          $len_before = strlen($html);
          $html = $this->_replaceIfOpen($html, $match_len + $len_diff, $match_str, $depth);
          $len_after = strlen($html);
          $len_diff += $len_after - $len_before;
        // is {/for}
        } else {
          $len_before = strlen($html);
          $html = $this->_replaceIfClose($html, $match_len + $len_diff, $match_str, $depth);
          $len_after = strlen($html);
          $len_diff += $len_after - $len_before;
          $depth--;
        }
      }

      return $html;
    }

    private function _prepareFors($html) {
      $matches = array();
      preg_match_all('/\{\/?for[^\}]*}/mi', $html, $matches, PREG_OFFSET_CAPTURE);

      if(count($matches[0]) % 2 != 0)
        throw new Exception("Template $template has no matching for count");

      $depth = 0;
      $len_diff = 0;
      $matches = $matches[0];

      foreach($matches as $match) {
        $match_str = $match[0];
        $match_len = $match[1];
        // is {for}
        if(!preg_match('/\{\/for[^\}]*/i', $match_str)) {
          $depth++;
          $len_before = strlen($html);
          $html = $this->_replaceForOpen($html, $match_len + $len_diff, $match_str, $depth);
          $len_after = strlen($html);
          $len_diff += $len_after - $len_before;
        // is {/for}
        } else {
          $len_before = strlen($html);
          $html = $this->_replaceForClose($html, $match_len + $len_diff, $match_str, $depth);
          $len_after = strlen($html);
          $len_diff += $len_after - $len_before;
          $depth--;
        }
      }
      return $html;
    }

    private function _replaceForOpen($html, $position, $tmpl_for, $depth) {
      $matches = array();
      preg_match('/array=\"\$?([^"]*)\"/i', $tmpl_for, $matches);
      $array = $matches[1];
      $array = str_ireplace('.', '->', $array);
      $php_for = '<?php foreach($' . $array . ' as $key => $value) {' .
                 '  $_key' . $depth . ' = $key;' .
                 '  $_value' . $depth . ' = $value;' .
                 '?>';
      $num = 1;
      $html = str_replace($tmpl_for, $php_for, $html, $num);

      return $html;
    }

    private function _replaceForClose($html, $position, $tmpl_for, $depth) {
      $php_for = '<?php } ' .
                 '  $key = $_key' . $depth . ';' .
                 '  $value = $_value' . $depth . ';' .
                 '  unset($_key' . $depth . ');' .
                 '  unset($_value' . $depth . ');' .
                 '?>';
      $num = 1;
      $html = str_replace($tmpl_for, $php_for, $html, $num);

      return $html;
    }

    private function _replaceIfOpen($html, $position, $tmpl_for, $depth) {
      $matches = array();
      preg_match('/condition=\"(\$?[^"]*)\"/i', $tmpl_for, $matches);
      $condition = $matches[1];
      $html = preg_replace('/(\$[a-zA-Z0-9_]+)(\.)([a-zA-Z0-9_]+)/mi', '$1[\'$3\']', $html);
      $php_for = '<?php if(' . $condition . ') { ?>';
      $num = 1;
      $html = str_replace($tmpl_for, $php_for, $html, $num);

      return $html;
    }

    private function _replaceIfClose($html, $position, $tmpl_for, $depth) {
      $php_for = '<?php } ?>';
      $num = 1;
      $html = str_replace($tmpl_for, $php_for, $html, $num);

      return $html;
    }

  }
?>