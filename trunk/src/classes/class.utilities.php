<?php
    /**
     * Utilities Class bundles commonly used methods
     * @author M. Käser
     * @date 25.10.2014
     */
  class Utilities {

    /**
     * returns the contents of a file
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

    /**
     * replaces keys in an associative array inside a template with its values
     */
    public static function templateReplace($template, $args, $prefix='{', $suffix='}') {
      foreach($args as $key => $value)
        $template = str_ireplace(static::varIt($key, $prefix, $suffix), $value, $template);
      return $template;
    }

    /**
     * Prefixes and suffixes a value
     */
    public static function varIt($value, $prefix='{', $suffix='}') {
      return $prefix . $value . $suffix;
    }

    /**
     * Checks if an array is associative or not
     */
    public static function isAssoc($array) {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Hashes a string
     */
    public static function hash($str, $salt) {
      return md5($str . $salt);
    }

    /**
    * Creates a Selectbox in html with the option and
    * @author TSCM
    * @param array - list of option => Values
    * @return string - html code for a select statement
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
    public static function buildParagraph($array, $ignore=array('type', 'version', 'genre')) {
      //init string
      $label1 = "label1";
      $html = "";

          foreach($array as $key => $value){
            if(in_array($key, $ignore))
              continue;
           $key = i($key);
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

  public static function pagination($current, $max, $page_size, $link, $prevnext=2) {
    $min_page = $current - $prevnext;
    $max_page = ceil($max / $page_size);
    $start = max($min_page, 0);
    $end = (int) min($max_page, $start + 1 + 2 * $prevnext);
    $links = array();
    for($now = $start; $now < $end; $now++) {
      $links[] = array('label' => $now + 1,
                       'link' => Utilities::templateReplace($link, array('page' => $now)),
                       'current' => $now == $current
                       );
    }

    $args = array(
      'start' => array('label' => '&lt;&lt;', 'link' => Utilities::templateReplace($link, array('page' => 0)),'current' => false),
      'links' => $links,
      'end' => array('label' => '&gt;&gt;', 'link' => Utilities::templateReplace($link, array('page' => $end - 1)),'current' => false),
      'current' => $current,
      'canPrev' => $current != 0 && $start != 0,
      'canNext' => $current != $end-1 && $end != $max_page
    );

    $pagination = TemplateRenderer::instance()->extendedRender('theme/templates/snippets/pagination.html', $args);
    return $pagination;
  }

  /**
  *  rest-client.docx
  * Gets the first wiki-text before the Table of Content
  * @author TSCM
  * @since 20150102
  * @param string - a Name or Booktitle , exp: "Lord of the Rings"
  * @return string - html code line
  * Explanation
  * //Base Url:
  * http://en.wikipedia.org/w/api.php?action=query
  *
  * //tell it to get revisions:
  * &prop=revisions
  *
  * //define page titles separated by pipes. In the example i used t-shirt company threadless
  * &titles=whatever|the|title|is
  *
  * //specify that we want the page content
  * &rvprop=content
  *
  * //I want my data in JSON, default is XML
  * &format=json
  *
  * //lets you choose which section you want. 0 is the first one.
  * &rvsection=0
  *
  * //tell wikipedia to parse it into html for you
  * &rvparse=1
  *
  * //only geht the "first"-Description of the wikipage, the one before the Table of Contents
  * &exintro=1
  *
  * //if I want to select something, I use action query, update / delete would be different
  * &action=query
  */
  public static function wiki($query){
    // load Zend classes
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Rest_Client');

    $decodeUtf8 = 0; //is decoding needed? Default not
    // define search query
    $wikiQuery = str_replace(" ","_",$query);

    try {

      //initialize REST client
      $lang = I18n::lang();
      $wikiLang = strtolower($lang);
      $webPagePrefix = "http://";
      $webPageUrl = ".wikipedia.org/w/api.php";
      //build the wiki api. be sure, that $wikiLang exists, exp: de or en

      $wikipedia = new Zend_Rest_Client($webPagePrefix.$wikiLang.$webPageUrl);
      $wikipedia->action('query'); //standard action, i want to GET...
      $wikipedia->prop('extracts');//what do i want to extract? page info
      $wikipedia->exintro('1'); // only extract the intro? (pre-Table of content) 1= yes, 0=now
      $wikipedia->titles($wikiQuery); //title is the wiki title to be found
      $wikipedia->format('xml'); //what format should be returned? exp: json, txt, php,
      $wikipedia->continue(''); //has to be set, otherwise wikimedia sends a warning

      // perform request
      // iterate over XML result set
      $result = $wikipedia->get();
      //print_r($result);
      $rs = $result->query->pages->page->extract;

      if($decodeUtf8){
        $rs = utf8_decode($rs);
      }

      //strip html Tags to get a clean string
    $rsFinal = strip_tags($rs);

      return $rsFinal;

    } catch (Exception $e) {
        die('ERROR: ' . $e->getMessage());
    }

  }//end wiki

  /**
   * Cuts a text at the provided length.
   * If the cut is made between a word, the whole word is truncated.
   *
   * @param $text - text to be cut
   * @param $maxLength - maximum length of text
   * @param $suffix - suffix which is added if the text is too long
   */
  public static function cutText($text, $maxLength, $suffix='...') {
    // Text is too long, shorten it
    if(strlen($text) > $maxLength) {
      $text = substr($text, 0, $maxLength);
      // cut after a space
      $text = substr($text, 0, strrpos($text, ' '));
      return $text . $suffix;
    }
    //not too long, return it all
    return $text;
  }

}
?>