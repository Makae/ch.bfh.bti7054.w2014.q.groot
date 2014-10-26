<?php
  class Core {
    private static $instance = null;
    private $controller;
    private $db;

    private function __construct() {
      session_start();

      $this->_loadInterfaces();
      $this->_loadClasses();
      $this->_loadModels();
      TemplateRenderer::instance()->setTplDir(TEMPLATE_TMP_DIR);
    }

    /*
      @desc: this part has to be removed from the Konstructor,
             because the called Classes access the core and by
             that the Core::instance() method. Thus an endless recursion
             occured.
    */
    private function postConstruct() {
      $this->db = DB::instance();
      I18N::instance()->addFolder('i18n');

      UserHandler::instance();

      $this->controller = Controller::instance();
    }

    public static function instance() {
      if(!is_null(static::$instance))
        return static::$instance;
      static::$instance = new Core();
      static::$instance->postConstruct();
      return static::$instance;
    }

    public function redirectAndDie($view, $params=array()) {
      header('Location: ' . WWWROOT . '?' . http_build_query($params));
      die();
    }

    public function getDb() {
      return $this->db;
    }

    public function render() {
      $this->controller->init();
      return $this->controller->render();
    }

    private function _loadModels() {
      $files = glob('classes/models/class.*.php');
      foreach($files as $file)
          require_once($file);
    }

    private function _loadClasses() {
      $files = glob('classes/class.*.php');
      foreach($files as $file)
        if($file != __FILE__)
          require_once($file);
    }

    private function _loadInterfaces() {
      $files = glob('interfaces/interface.*.php');
      foreach($files as $file)
        require_once($file);
    }

  }
?>