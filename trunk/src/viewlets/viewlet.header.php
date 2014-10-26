<?php
  class GrootHeaderViewlet implements IViewlet {

    public static function name() {
      return 'header';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      $main_menu = array();
      $main_menu[] = ('Kategorien');
      $main_menu[] = ('Profil');
      $main_menu[] = ('Wunschzettel');
      $main_menu[] = ('Warenkorb');
      return TemplateRenderer::instance()->extendedRender('theme/templates/viewlets/viewlet.header.html', array(
        'main_menu' => $main_menu
      ));
    }

    public function ajaxCall() {

    }

  }
?>