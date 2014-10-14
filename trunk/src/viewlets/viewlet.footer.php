<?php
  class GrootFooterViewlet implements IViewlet {

    public static function name() {
      return 'footer';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      return '<div class="impressum">Impressum</div>
      <div class="impressum">Kontakt</div>
      <div class="impressum">Shopversion</div>
      <div class="impressum">&Uuml;ber uns</div>
      <div class="impressum">Support Hotline</div>';
    }

    public function ajaxCall() {

    }

  }
?>