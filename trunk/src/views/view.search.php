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

    public function ajaxBooklist() {
      return "lol";
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    private function _getSearchResult($str, $category) {
      $category = !isset($category) || $category == null || $category == '' ? null : $category;
      $books = Core::instance()->getDb()->searchBooks($str, $category);
      if($str != '') {
        foreach($books as $key => $book) {
          $books[$key]['title'] = Utilities::highlight($book['title'], $str);
          $books[$key]['description'] = Utilities::highlight($book['description'], $str);
        }
      }
      return $books;
    }

    public function render() {
      $query = isset($_REQUEST['query']) ? $_REQUEST['query'] : null;
      $cat = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : null;
      $result = $this->_getSearchResult($query, $cat);
      $args = array(
        'title' => 'Search',
        'books' => $result,
        'text_details' => i('To the details')
      );

      $content = TemplateRenderer::instance()->extendedRender('theme/templates/snippets/booklist.html', $args);
      $args = array(
        'title' => i('We found following books for you'),
        'result' => $content
        );
      return TemplateRenderer::instance()->extendedRender('theme/templates/views/search.html', $args);
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>