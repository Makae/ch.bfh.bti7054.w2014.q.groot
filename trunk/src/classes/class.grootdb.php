<?php
  class Grootdb extends DB {

    public function searchBooks($str, $cat=null, $page=0, $size=10) {
      $conditions =  '(name LIKE "%{%str%}%" OR isbn LIKE "%{%str%}%") {%cond_genre%}';
      $query = 'SELECT {%columns%} FROM {%table%} as b' .
               '  LEFT JOIN {%table_book_genre%} as bg ON (b.id = bg.book_id)' .
               '  LEFT JOIN {%table_genre%} as g ON (bg.genre_key = g.id)' .
               'WHERE {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs(BookModel::table(), null, null, 'name ASC', array($page, $size));
      $args['table_book_genre'] = BookGenreModel::table();
      $args['table_genre'] = GenreModel::table();
      $args['conditions'] = $conditions;
      $args['str'] = $this->_esc($str);
      $args['cond_genre'] = is_null($cat) ? '' : ' AND c.key = "' . $this->_esc($cat) . '" ';
      $query = $this->_queryTemplate($query, $args);
      die($query);
      $result = $this->query($query);
      return $this->_assocRows($result);
    }
  }
?>