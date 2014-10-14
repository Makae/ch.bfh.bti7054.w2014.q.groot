<?php
  class Core {
    private static $instance = null;
    private $controller;

    private function __construct() {
      $files = glob('interfaces/interface.*.php');

      foreach($files as $file)
        require_once($file);

      $files = glob('classes/class.*.php');
      foreach($files as $file)
        if($file != __FILE__)
          require_once($file);

      $this->controller = Controller::instance();
      $this->controller->init();

    }

    public function instance() {
      if(self::$instance != null)
        return self::$instance;
      return self::$instance = new Core();
    }

    public function render() {
      return $this->controller->render();
    }

  }
?>