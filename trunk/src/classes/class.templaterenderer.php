<?php
  /*
    @author: M. Käser
    @date:   25.10.2014
    @desc:   The TemplateRenderer allows the decoupoling of php from html
  */
  class TemplateRenderer {
    private static $instance = null;
    private static $var_prefix = '{%';
    private static $var_suffix = '%}';
    private static $tmp_dir = 'TR_TEMP';
    private static $salt = TEMPLATE_SALT;

    private function __construct() {}

    public function instance() {
      if(self::$instance != null)
        return self::$instance;
      return self::$instance = new TemplateRenderer();
    }

    /*
      @desc: sets the template directory, please check
             that the permissions are set correctly
    */
    public function setTplDir($dir) {
      $dir = realpath($dir);
      if(!file_exists($dir) || !is_dir($dir))
        throw new Exception("This folder $dir does not exist!");

      TemplateRenderer::$tmp_dir = $dir;
    }

    /*
      @desc: Renders a template file
      @args: $template -> path of template file
             $args -> associative array
    */
    public function render($template, $args) {
      if(!file_exists($template))
        throw new Exception('The template "' . $template . '" does not exist');

      $html = Utilities::getFileContent($template);
      $html = Utilities::templateReplace($html, $args, static::$var_prefix, static::$var_suffix);
      return $html;
    }

    /*
      @desc: renders a template with additional control keywords like for / ifs and assoc-arrays
      @args: $template -> path of the template
             $args -> associative array with the values
    */
    public function extendedRender($template, $args) {
      $html = Utilities::getFileContent($template);

      $tpl_php = $this->_prepareVariables($html, $args);
      $tpl_php = $this->_prepareFors($tpl_php);
      $tpl_php = $this->_prepareIfs($tpl_php);

      return $this->_templateInclude($template, $tpl_php, $args);
    }

    /*
       @desc: generates a temporary-php File which is then included,
              the printed values are then returned
       @args: $template -> template file
              $php -> PHP / html code to be written in template file
              $args -> associative array
    */
    private function _templateInclude($template, $php, $args) {
      $tmp_path = static::$tmp_dir . '/tmp.' . basename($template). '.' . Utilities::hash($template, static::$salt) . '.php';

      $fh = fopen($tmp_path, 'w');
      fwrite($fh, $php);

      extract($args);
      ob_start();
      require($tmp_path);
      $html = ob_get_clean();
      return $html;
    }

    /*
      @desc: Replaces Variables-Templates {$value} such that they are echoed when executed
             Additionally replaces {$value.key} to $value['key'];
    */
    private function _prepareVariables($html) {
      $html = preg_replace('/\{(\$[^\}]*)\}/mi', '<?php if(isset($1)) echo $1;?>', $html);
      $html = preg_replace('/(\$[a-zA-Z0-9_]+)(\.)([a-zA-Z0-9_]+)/mi', '$1[\'$3\']', $html);
      return $html;
    }

    /*
       @desc: Replaces {if condition="[COND]"}[IN_IF]{/if} to if([COND]) { [IN_IF]} in order
              to be properly executed
    */
    private function _prepareIfs($html) {
      $matches = array();
      // Rreplace the
      preg_match_all('/\{\/?if[^\}]*}/mi', $html, $matches, PREG_OFFSET_CAPTURE);

      if(count($matches[0]) % 2 != 0)
        throw new Exception("Template $template has no matching if tags count");

      $depth = 0;
      $len_diff = 0;
      $matches = $matches[0];
      foreach($matches as $match) {
        $match_str = $match[0];
        $match_len = $match[1];
        // is {if}
        if(!preg_match('/\{\/if[^\}]*/i', $match_str)) {
          $depth++;
          $len_before = strlen($html);
          $html = $this->_replaceIfOpen($html, $match_len + $len_diff, $match_str, $depth);
          $len_after = strlen($html);
          $len_diff += $len_after - $len_before;
        // is {/if}
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

    /*
      @desc: replaces for markers {for array="$entries"}[IN_FOR]{/for} to
             foreach($entries as $key => $value){ [IN_FOR] } in order to
             be properly executed when the html is included
    */
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
                 '  if(isset($_key)) { $key = $_key' . $depth . ';' .
                 '  unset($_key' . $depth . ');}' .
                 '  if(isset($_value)) { $value = $_value' . $depth . ';' .
                 '  unset($_value' . $depth . ');}' .
                 '?>';
      $num = 1;
      $html = str_replace($tmpl_for, $php_for, $html, $num);

      return $html;
    }

    private function _replaceIfOpen($html, $position, $tmpl_if, $depth) {
      $matches = array();
      preg_match('/condition=\"(\$?[^"]*)\"/i', $tmpl_if, $matches);
      $condition = $matches[1];
      $php_if = '<?php if(' . $condition . ') { ?>';
      $num = 1;
      $html = str_replace($tmpl_if, $php_if, $html, $num);

      return $html;
    }

    private function _replaceIfClose($html, $position, $tmpl_if, $depth) {
      $php_if = '<?php } ?>';
      $num = 1;
      $html = str_replace($tmpl_if, $php_if, $html, $num);

      return $html;
    }

  }
?>