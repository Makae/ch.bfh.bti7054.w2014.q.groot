<?php
  class GrootDB {
    public function searchBooks($str, $cat) {
      $conditions =  'name LIKE "%{%str%}%" OR isbn LIKE "%{%str%}%"';
      $query = 'SELECT {%columns%} FROM {%table%} {%conditions%} {%orders%} {%limit%}';

      $args = $this->_prepareArgs($table, $conditions, $columns, $orders, $limit);
      $args['conditions'] = $conditions;
      $query = $this->_queryTemplate($query, $args);
      $result = $this->query($query);
      return $this->_assocRows($result);
    }
  }
?>