<?php
  class Core {
    private static $instance = null;
    private $controller;
    private $db;

    private function __construct() {
      $files = glob('interfaces/interface.*.php');

      foreach($files as $file)
        require_once($file);

      $files = glob('classes/class.*.php');
      foreach($files as $file)
        if($file != __FILE__)
          require_once($file);

      I18N::instance('de')->addFolder('i18n');
      $this->db = DB::instance();
      $this->controller = Controller::instance();

    }

    public function getDb() {
      return $this->db;
    }

    public function instance() {
      if(self::$instance != null)
        return self::$instance;
      return self::$instance = new Core();
    }

    public function render() {
      $this->controller->init();
      return $this->controller->render();
    }

  }
?>