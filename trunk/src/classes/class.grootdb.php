<?php
  class Grootdb extends DB {

    public function searchBooks($str, $cat=null, $page=0, $size=10, $columns=null) {
      $conditions =  '(description LIKE "%{%str%}%" OR name LIKE "%{%str%}%" OR isbn LIKE "%{%str%}%") {%cond_genre%}';
      $query = 'SELECT {%columns%} FROM {%table%} as b' .
               '  LEFT JOIN {%table_book_genre%} as bg ON (b.id = bg.book_id)' .
               '  LEFT JOIN {%table_genre%} as g ON (bg.genre_id = g.id)' .
               '  WHERE {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs(BookModel::table(), null, $columns, 'name ASC', array($page, $size));
      $args['table_book_genre'] = BookGenreModel::table();
      $args['table_genre'] = GenreModel::table();
      $args['conditions'] = $conditions;
      $args['str'] = $this->_esc($str);
      $args['cond_genre'] = is_null($cat) ? '' : ' AND g.id = "' . $this->_esc($cat) . '" ';
      $query = $this->_queryTemplate($query, $args);

      $result = $this->query($query);
      return $this->_assocRows($result);
    }

    public function countSearchBooks($str, $cat=null) {
      $num = $this->searchBooks($str, $cat, $page=0, $size=1, $columns='COUNT(*) as num');
      return $num[0]['num'];
    }

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