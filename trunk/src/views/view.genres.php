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
      $books = Core::instance()->getDb()->booksByGenre($genre, $page, $size);
      return $books;
    }

    public function render() {
      $genres = GenreModel::getTranslatedGenres();
      $showcase_set = array();
      $page = 0;
      $size = 4;
      foreach($genres as $genre) {
        $books = $this->_getBooksByGenre($genre['value'], $page, $size);
        if(count($books) == 0)
          continue;

        $args = array(
          'books' => $books,
          'style' => 'showcase',
          'text_details' => i('To the details')
        );
        $showcase = TemplateRenderer::instance()->extendedRender('theme/templates/snippets/showcase.html', $args);
        $showcase_set[] = array('genre' => $genre['label'], 'showcase' => $showcase);
      }
      $args = array(
        'title' => i('Check out these books'),
        'showcases' => $showcase_set
      );
      return TemplateRenderer::instance()->extendedRender('theme/templates/views/genres.html', $args);
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>