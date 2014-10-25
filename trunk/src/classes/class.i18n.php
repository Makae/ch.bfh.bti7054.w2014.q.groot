<?php
  class I18n {
    private static $instance = null;
    private $folder = null;
    private static $lang = null;
    private static $available_languages = null;
    private static $translations = array();
    private static $folders = array();

    private function __construct($lang) {
      static::$lang = $lang;
      if(!isset(static::$translations[$lang])) {
        static::$translations[$lang] = array();
      }
      static::loadFolders();
    }

    public static function instance($lang=null) {
      if($lang == null || !static::validLang($lang))
       $lang = I18N::lang();

      if(static::$instance != null)
        return static::$instance;
      return static::$instance = new I18n($lang);
    }

    public static function lang() {
      if(static::$lang)
        return static::$lang;

      if(isset($_REQUEST['lang']) && static::validLang($_REQUEST['lang']))
        return static::$lang = $_REQUEST['lang'];

      if(isset($_SESSION['lang']) && static::validLang($_SESSION['lang']))
        return static::$lang = $_SESSION['lang'];

      $user = UserHandler::instance()->user();
      if(!is_null($user) && static::validLang($user->lang()))
        return static::$lang = $user->lang();

      return static::$lang = DEFAULT_LANGUAGE;
    }

    public static function validLang($lang) {
      if(!in_array($lang, static::availableLanguages()))
        return false;
      return true;
    }

    public static function availableLangauges() {
      if(is_null(static::$available_languages))
      static::$available_languages = explode(',', AVAILABLE_LANGUAGES);
      return static::$available_languages;
    }

    public static function translate($key, $args=array()) {
      $inst = I18N::instance();
      if(!array_key_exists($key, static::$translations[static::$lang]))
        $val = $key;
      else
        $val = static::$translations[static::$lang][$key];

      $GLOBALS['debug'] = true;
      return Utilities::templateReplace($val, $args);
    }

    public function addFolder($folder) {
      $folder = realpath($folder);

      if(!file_exists($folder))
        throw Exception("The folder $folder does not exist");

      $this->appendFolder(static::$lang, $folder);
      $this->loadLanguageFiles($folder);
    }

    private function appendFolder($lang, $folder_path) {
      $found = false;
      foreach(static::$folders as &$folder) {
        if($folder['path'] == $folder_path) {
          if(in_array($lang, $folder['langs']))
            return;

          $found = true;
          $folder['langs'][] = $lang;
        }
      }

      if(!$found)
        static::$folders[] = array('path' => $folder_path, 'langs' => array($lang));
    }

    private static function loadFolders() {
      foreach(static::$folders as $folder)
        if(!in_array(static::$lang, $folder['langs']))
          I18N::instance(static::$lang)->loadLanguageFiles($folder);
    }

    private function loadLanguageFiles($folder) {
      $matches = array();
      $regex = '/("([^"]*)":\s?\n\"([^"]*)"[^"]?)/i';
      $lang_file = $folder . '/' . static::$lang . '.txt';
      $content = Utilities::getFileContent($lang_file);

      preg_match_all($regex, $content, $matches);

      $translations = array();
      if(isset($matches[2]) && isset($matches[3]))
        $translations = array_combine($matches[2], $matches[3]);

      static::$translations[static::$lang] = array_merge(static::$translations[static::$lang], $translations);
    }

  }

  function i($key, $args=array()) {
    return I18N::translate($key, $args);
  }
?>