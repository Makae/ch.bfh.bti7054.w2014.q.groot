<?php
  class GrootShopView implements IView {

    public function name() {
      return 'home';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletSubMenu() {
      return null;
    }

    public function viewletFooter() {
      return null;
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      return "shop render";
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>