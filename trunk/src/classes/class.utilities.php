<?php
  class Utilities {

    public static function getFileContent($file_path) {
      if(!file_exists($file_path))
        throw new Exception("File $file_path doesn't exist");

      $fh = fopen($file_path, 'r');
      $text = fread($fh, filesize($file_path));

      fclose($fh);

      return $text;
    }

    public static function templateReplace($template, $args, $prefix='{', $suffix='}') {
      foreach($args as $key => $value)
        $template = str_ireplace(static::varIt($key, $prefix, $suffix), $value, $template);
      return $template;
    }

    public static function varIt($value, $prefix='{', $suffix='}') {
      return $prefix . $value . $suffix;
    }

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
    *@author TSCM
    *@param array - list of option => Values 
    *@return string - html code for a select statement
    */
    public static function buildSelectbox($array, $selectName) {


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
                  <option value='".$row['value']."'>".$row['label']."</option>
                ";

          
        }
      $selectbox_code .= "
        </select>
      ";
      return $selectbox_code;
    }



  }
?>