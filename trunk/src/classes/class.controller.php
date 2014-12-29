<?php
  /*
    @author: M. Käser
    @date: 02.10.2014
    @desc: The controller decides which views are called and manages the data
           which is sent from the views to the viewlets
  */
  class Controller {
    private static $instance = null;
    private $view_key = 'home';
    private $view = null;
    private $viewlets = array();

    private function __construct() {}

    public function instance() {
      if(self::$instance != null)
        return self::$instance;

      self::$instance = new Controller();
      self::$instance->postConstruct();
      return self::$instance;
    }

    private function postConstruct() {
      $files = glob('viewlets/viewlet.*.php');
      foreach($files as $file) {

        $matches = array();
        //preg_match takes the variable $matches by reference and alters it inside the function body
        if(!preg_match('/viewlet\.(.+)\.php$/', $file, $matches))
          continue;

        $cls = 'Groot' . $matches[1] . 'Viewlet';
        if(class_exists($cls))
          $this->viewlets[$cls::name()] = new $cls();

      }
    }

    /*
      @desc: decides which view shall be called and initializes the view
             the process method is then called in which the view can
             process the data. Eg. Save new entry, replace data etc.
    */
    public function init() {
      $this->view_key = isset($_REQUEST['view']) ? $_REQUEST['view'] : $this->view_key;
      $cls = 'Groot' . ucfirst($this->view_key) . 'View';

      if(!class_exists($cls))
        throw new Exception('The view "' . $this->view_key . '" does not exist');

      // instantiate the view
      $this->view = new $cls();
      $this->view->process();

      if(!$this->isAjaxRequest())
        $this->_processViewlets();

    }

    /*
      @desc: this method gets the config data for each viewlet via the defined
             functions in the current view. As example the view GrootShopView
             can display other submenu entries than the GrootHomeView
    */
    private function _processViewlets() {
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

    private function renderAjax() {
      $fn = isset($_REQUEST['ajax_fn']) ? 'ajax' . ucfirst($_REQUEST['ajax_fn']) : null;
      $call_pair = array($this->view, $fn);

      if($fn == null)
        throw new Exception("No Ajax-method defined which shall be called");

      if(!is_callable($call_pair))
        throw new Exception("The called method '". get_class($this->view) . "::$fn' does not exist");

      return call_user_func_array($call_pair, array());

    }

    /*
      @desc: calls the render method of  the current view
             and renders the main page with tha data from
             the viewlets.
             This method sets the header of the page.
             - text/json for ajax requests
             - text/html for normal requests

    */
    public function render() {
      if($this->isAjaxRequest()) {
        header('Content-Type: text/json; charset=utf-8');
        $response = $this->renderAjax();
        return $response;
      }

      $args = array(
        'WWWROOT' => WWWROOT,
        'WWWTHEME' => WWWTHEME,
        'WWWCSS' => WWWCSS,
        'WWWJS' => WWWJS,
        'header' => $this->viewlets['header']->render(),
        'navi' => $this->viewlets['navi']->render(),
        'footer' => $this->viewlets['footer']->render(),
        'view_content' => $this->view->render()
      );

      header('Content-Type: text/html; charset=utf-8');
      return TemplateRenderer::instance()->extendedRender('theme/templates/index.html', $args);
    }

    public function getView() {
      return $this->view;
    }

    public function getViewKey() {
      return $this->view_key;
    }

    public function isAjaxRequest() {
      if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1)
        return true;
      return false;
    }

  }


?>