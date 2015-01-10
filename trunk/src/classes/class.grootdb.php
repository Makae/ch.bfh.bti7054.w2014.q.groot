<?php
  /**
   * Extends the Funcitonality of the DB-Class and provides a project-specific interface
   */
  class Grootdb extends DB {

    /**
     * Searches books based on a query-string and genre.
     * It searches inside the titles and the description
     *
     * @param string $str - the query string
     * @param int $genre - restricts the search to a genre
     * @param int $page - which page (for limit parameter)
     * @param int $size - the page size
     * @param array<string> $columns - which columns to be returned
     * @param boolean $only_titles - search is only performed in the title column
     */
    public function searchBooks($str, $genre=null, $page=0, $size=10, $columns=null, $only_titles=false) {
      if(!$only_titles)
        $conditions =  '(description LIKE "%{%str%}%" OR title LIKE "%{%str%}%" OR isbn LIKE "%{%str%}%") {%cond_genre%}';
      else
        $conditions =  '(title LIKE "%{%str%}%") {%cond_genre%}';
      $query = 'SELECT {%columns%} FROM {%table%} as b' .
               '  LEFT JOIN {%table_book_genre%} as bg ON (b.id = bg.book_id)' .
               '  LEFT JOIN {%table_genre%} as g ON (bg.genre_id = g.id)' .
               '  WHERE {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs(BookModel::table(), null, $columns, 'title ASC', array($page*$size, $size));
      $args['table_book_genre'] = BookGenreModel::table();
      $args['table_genre'] = GenreModel::table();
      $args['conditions'] = $conditions;
      $args['str'] = $this->_esc($str);
      $args['cond_genre'] = is_null($genre) ? '' : ' AND g.id = "' . $this->_esc($genre) . '" ';
      $query = $this->_queryTemplate($query, $args);

      $result = $this->query($query);
      return $this->_assocRows($result);
    }

    /**
     * Returns the number of books which have been found by
     * a particular search
     */
    public function countSearchBooks($str, $genre=null) {
      $num = $this->searchBooks($str, $genre, $page=0, $size=1, $columns='COUNT(*) as num');
      return $num[0]['num'];
    }

    /**
     * Returns books of e certain genre
     *
     * @param int $genre - the genre of the books
     * @param int $page - the page idx
     * @param int $size - the size of the page
     */
    public function booksByGenre($genre, $page=0, $size=10) {
      $query = 'SELECT {%columns%} FROM {%table%} as b' .
               '  LEFT JOIN {%table_book_genre%} as bg ON (b.id = bg.book_id)' .
               '  {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs(BookModel::table(), array('bg.genre_id' => $genre), null, 'name ASC', array($page, $size));
      $args['table_book_genre'] = BookGenreModel::table();
      $args['table_genre'] = GenreModel::table();
      $query = $this->_queryTemplate($query, $args);
      $result = $this->query($query);

      return $this->_assocRows($result);
    }


  }
?>