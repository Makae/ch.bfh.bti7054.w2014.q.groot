<?php
    /*
    @author: M. Käser
    @date:   25.10.2014
    @desc:   Utilities Class bundles commonly used methods
  */
  class Utilities {

    /*
      @desc: returns the contents of a file
    */
    public static function getFileContent($file_path) {
      if(!file_exists($file_path))
        throw new Exception("File $file_path doesn't exist");

      $fh = fopen($file_path, 'r');
      $text = fread($fh, filesize($file_path));

      fclose($fh);

      return $text;
    }

    public static function highlight($str, $search, $replace="<span class='highlight'>$0</span>") {
      return preg_replace('/' . $search .'/i', $replace, $str);
    }

    /*
      @desc: replaces keys in an associative array inside a template with its values
    */
    public static function templateReplace($template, $args, $prefix='{', $suffix='}') {
      foreach($args as $key => $value)
        $template = str_ireplace(static::varIt($key, $prefix, $suffix), $value, $template);
      return $template;
    }

    /*
      @desc: Prefixes and suffixes a value
    */
    public static function varIt($value, $prefix='{', $suffix='}') {
      return $prefix . $value . $suffix;
    }

    /*
      @desc: Checks if an array is associative or not
    */
    public static function isAssoc($array) {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /*
      @desc: hashes a string
      @trivia: adding a salt-portion to the hasing method (Here MD5)
               allows the method to be more secure. If no salt is added, hashed
               passwords would look exactly the same in each DB. eg. Amazon / Google / GrootShop...
               If one DB is hacked and the hacker nows the hashes for the passwords
               he can simply reverse engineer the real passwords of the other sites
               which aswell do not use a salt-portion to disguise their passwords.
    */
    public static function hash($str, $salt) {
      return md5($str . $salt);
    }

    /**
    * Creates a Selectbox in html with the option and
    * @author TSCM
    *@param array - list of option => Values
    *@return string - html code for a select statement
    */
    public static function buildSelectbox($array, $selectName, $activeValue) {


      //init string
      $selectbox_code = "";
      $selectbox_code .= "
        <select name='$selectName'>
      ";
      /*
<select name="category">
          <option value="1">Fantasy</option>
          <option value="2">Horror</option>
          <option value="3">Krimi</option>
          <option value="4">Kinderbuch</option>
          <option value="5">Berufswelt</option>
          <option value="6">Kunst</option>
          <option value="7">Sport</option>
        </select>

      */


        foreach ($array as $row){
          $row["label"] = i($row["label"]);
          $selectbox_code .= "
                  <option value='".$row['value']."' " . ($row['value'] == $activeValue ? 'selected="selected"' : '')  . " >".$row['label']."</option>
                ";


        }
      $selectbox_code .= "
        </select>
      ";
      return $selectbox_code;
    }


   /**
    * Creates a Paragraph for each entry in the array and wrap around html
    *@author TSCM
    *@param multi dim. array - list of products: e.g.  books [] => $key => $valueoption => Values
    *@return string - html code for a paragraph list
    */
    public static function buildParagraph($array) {
      //init string
      $label1 = "label1";
      $html = "";
      /*


      */

          foreach($array as $key => $value){
//var_dump($key);
           $key = i($key);
  //  var_dump($key);
           $html .= "
           <p><div class=\"$label1\">$key: </div>$value</p>
                ";
          }

      return $html;
    }

/**
  * copyed from 06_php_part03_v08.pdf from web programming lession and altered
  * returns a String with the html insted of echoing it directly
  * @author TSCM
  * @since 20141102
  * @param string - id of the option
  * @param string - visible to the user text
  * @return string - html code line
  */
    //
    public static function makeOption($value, $text) {
      $html = "";
      $html = "<option value=\"$value\">$text</option>";
      return $html;
    }

/**
  *  copyed from 06_php_part03_v08.pdf from web programming lession and altered
  * returns a String with the html insted of echoing it directly
  * @author TSCM
  * @since 20141102
  * @param string - id of the option
  * @param string - visible to the user text
  * @param string - visible to the user text
  * @return string - html code line
  */
    public static function makeSelection($name, $options, $size = 3) {
      $html = "";
      $html .= "<select name=\"$name\" size=\"$size\">";
      foreach($options as $value => $text){
        $html .= makeOption($value, $text);
      }
      $html .=  "</select>";
    }

/**
  *  copyed from 06_php_part03_v08.pdf from web programming lession and altered
  * returns a String with the html insted of echoing it directly
  * @author TSCM
  * @since 20141102
  * @return string - html code line
  */
  public static function hiddenInputsFromPost() {
    $html = "";
    if (isset($_POST))
    foreach ($_POST as $name => $value){
      $html .=  "<input class=\"hidden input2\" type=\"input\" name=\"$name\" value=\"$value\">";
    }
    return $html;

  }


  }
?>