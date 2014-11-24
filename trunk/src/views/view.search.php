<?php
  class GrootSearchView implements IView {

    public function name() {
      return 'shearch';
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

    private function _getSearchResult($str, $category) {

      $result = Core::instance()->getDb()->searchBooks($str, $category);
    }

    public function render() {
      $result = $this->_getSearchResult($_REQUEST['query'], $_REQUEST['cat']);
      $args = array(
        'title' => 'Search',
        'result' => $result
      );
      return TemplateRenderer::instance()->extendedRender('theme/templates/views/search.html', $args);
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>