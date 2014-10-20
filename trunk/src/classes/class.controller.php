<?php

  class Controller {
    private static $instance = null;
    private $view_key = 'home';
    private $view = null;
    private $viewlets = array();

    private function __construct() {
      $files = glob('views/view.*.php');
      foreach($files as $file)
        include_once($file);

      $files = glob('viewlets/viewlet.*.php');
      foreach($files as $file) {
        include_once($file);
        $matches = array();

        //preg_match takes the variable matches by reference and alters it inside the function body
        preg_match('/viewlet\.(.+)\.php$/', $file, $matches);
        $cls = 'Groot' . $matches[1] . 'Viewlet';

        if(class_exists($cls))
          $this->viewlets[$cls::name()] = new $cls();

      }
    }

    public function instance() {
      if(self::$instance != null)
        return self::$instance;
      return self::$instance = new Controller();
    }

    public function init() {
      $this->view_key = isset($_REQUEST['view']) ? $_REQUEST['view'] : $this->view_key;

      $cls = 'Groot' . ucfirst($this->view_key) . 'View';

      if(!class_exists('Groot' . ucfirst($this->view_key) . 'View'))
        throw new Exception('The view "' . $this->view_key . '" does not exist');
      $this->view = new $cls();

      $this->view->process();
      foreach($this->viewlets as $viewlet) {
        $name = $viewlet->name();
        $fn = 'viewlet' . ucfirst($name); // function which is called on th view
        $call_pair = array($this->view, $fn);

        $val = null;
        if(is_callable($call_pair))
          $val = call_user_func_array($call_pair, array());

        $viewlet->process($val);
      }

    }

    public function render() {
      $args = array(
        'header' => $this->viewlets['header']->render(),
        'navi' => $this->viewlets['navi']->render(),
        'footer' => $this->viewlets['footer']->render(),
        'view_content' => $this->view->render()
        );
      return TemplateRenderer::instance()->render('theme/templates/index.html', $args);
    }
  }


?>