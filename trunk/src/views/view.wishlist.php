<?php
  class GrootWishlistView implements IView {

    public function name() {
      return 'wishlist';
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
      return "This menu entry is for stylistic purposes only";
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>