<?php
  class Grootdb extends DB {

    public function searchBooks($str, $cat=null, $page=0, $size=10) {
      $conditions =  '(name LIKE "%{%str%}%" OR isbn LIKE "%{%str%}%") {%cond_cat%}';
      $query = 'SELECT {%columns%} FROM {%table%} as b' .
               '  LEFT JOIN {%table_book_category%} as g ON (b.id = g.book_id)' .
               '  LEFT JOIN {%table_category%} as c ON (c.key = g.category_key)' .
               'WHERE {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs(BookModel::table(), null, null, 'name ASC', array($page, $size));
      $args['table_book_category'] = BookCategoryModel::table();
      $args['table_category'] = CategoryModel::table();
      $args['conditions'] = $conditions;
      $args['str'] = $this->_esc($str);
      $args['cond_cat'] = is_null($cat) ? '' : ' AND c.key = "' . $this->_esc($cat) . '" ';
      $query = $this->_queryTemplate($query, $args);
            echo "<pre>";
            die(var_dump($query));
      $result = $this->query($query);

      return $this->_assocRows($result);
    }
  }
?>