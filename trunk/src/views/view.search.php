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

    private function _getSearchResult($str, $category, $page=0, $size=10) {
      $category = !isset($category) || $category == null || $category == '' ? null : $category;
      $books = Core::instance()->getDb()->searchBooks($str, $category, $page, $size);
      if($str != '') {
        foreach($books as $key => $book) {
          $books[$key]['title'] = Utilities::highlight($book['title'], $str);
          $books[$key]['description'] = Utilities::highlight($book['description'], $str);
        }
      }
      $total = Core::instance()->getDb()->countSearchBooks($str, $category);
      $result = array('books' => $books, 'total' => $total);
      return $result;
    }

    public function render() {
      $query = isset($_REQUEST['query']) ? $_REQUEST['query'] : null;
      $cat = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : null;
      $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
      $result = $this->_getSearchResult($query, $cat, $page, 10);

      $args = array(
        'books' => $result['books'],
        'text_details' => i('To the details')
      );
      $content = TemplateRenderer::instance()->extendedRender('theme/templates/snippets/booklist.html', $args);

      $pagination = Utilities::pagination($page, $result['total'], '?view=search&query='. $query . '&cat' . $cat . '&page={page}');
      $args = array(
        'title' => i('We found following books for you'),
        'result' => $content,
        'pagination' => $pagination
        );
      return TemplateRenderer::instance()->extendedRender('theme/templates/views/search.html', $args);
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>