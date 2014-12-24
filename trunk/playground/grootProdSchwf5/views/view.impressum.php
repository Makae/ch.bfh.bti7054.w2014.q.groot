<?php
  class GrootImpressumView implements IView {

    public function name() {
      return 'impressum';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletNavi() {
      return array();
    }

    public function viewletFooter() {
      return null;
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      return '
<ul class="">
        <div>Adresse:</div>
        <div>Groot Workgroup</div>
        <div>Grubenweg 15</div>
        <div>2558 Herblingen</div>
        <div>CH - Schweiz</div>
      </ul>';

      return "Here will be the impressum render soon ... ";
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>