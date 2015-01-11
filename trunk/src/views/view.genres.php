<?php
  class GrootGenresView implements IView {

    public function name() {
      return 'genres';
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

    private function _getBooksByGenre($genre, $page=0, $size=4) {
      return Core::instance()->getDb()->booksByGenre($genre, $page, $size);
    }

    public function render() {
      $genres = GenreModel::getTranslatedGenres();
      $showcase_set = array();
      $page = 0;
      $size = 4;
      foreach($genres as $genre) {
        $showcase = $this->_getShowCase($genre['value']);

        if(is_null($showcase))
          continue;

        $showcase_set[] = array('genre' => $genre['label'], 'showcase' => $showcase);
      }
      $args = array(
        'title' => i('Check out these books'),
        'showcases' => $showcase_set
      );
      return TemplateRenderer::instance()->extendedRender('theme/templates/views/genres.html', $args);
    }

    private function _getShowCase($genre, $page=0, $size=4) {
      $books = $this->_getBooksByGenre($genre, $page, $size);

      $num_books = Core::instance()->getDb()->countBookyByGenre($genre);

      if(count($books) == 0)
        return null;

      $args = array(
        'books' => $books,
        'style' => 'showcase',
        'text_details' => i('To the details'),
        'navigation' => true,
        'prev_hidden' => $num_books <= $size,
        'next_hidden' => count($books) < $size,
        'config' => urlencode(json_encode(array(
          'page' => $page,
          'size' => $size,
          'request' => Controller::instance()->getViewUrl() . '&ajax=1&ajax_fn=nextShowcasePage&page={%page%}&size={%size%}&genre=' . $genre
        )))
      );
      return TemplateRenderer::instance()->extendedRender('theme/templates/snippets/showcase.html', $args);
    }

    public function ajaxNextShowcasePage() {
      $genre = isset($_REQUEST['genre']) ? $_REQUEST['genre'] : null;
      $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
      $size = isset($_REQUEST['size']) ? $_REQUEST['size'] : 4;

      $result = $this->_getShowCase($genre, $page, $size);
      return json_encode(array('html' => $result));

    }

  }
?>