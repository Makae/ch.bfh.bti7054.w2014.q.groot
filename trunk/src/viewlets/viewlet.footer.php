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
      return '<div class="impressum stdanimation1_2">Impressum</div>
      <div class="impressum stdanimation1_2">Kontakt</div>
      <div class="impressum stdanimation1_2">Shopversion</div>
      <div class="impressum stdanimation1_2">&Uuml;ber uns</div>
      <div class="impressum stdanimation1_2">Support Hotline</div>';
    }

    public function ajaxCall() {

    }

  }
?>