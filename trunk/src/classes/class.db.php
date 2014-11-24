<?php
  /*
   * @author: M. Käser
   * @date: 05.10.2014
   * @desc: This class provides a simple interface for interacting with
   *        the MySQL-Database
   */
  class DB {
    protected static $instance = null;

    protected $host = null;
    protected $user = null;
    protected $pwd = null;
    protected $db = null;
    /*
      @trivia: connection to the database, it is necessary for
               php to clearly identify which requests has to be sent where
    */
    protected $con = null;

    protected function __construct($host=null, $user=null, $pwd=null, $db=null) {
      $this->host = is_null($host) ? DB_HOST : $host;
      $this->user = is_null($user) ? DB_USER : $user;
      $this->pwd = is_null($pwd) ? DB_PASSWORD : $pwd;
      $this->db = is_null($db) ? DB_DATABASE : $db;

      // this is the conneciton to the MySQL-DB
      $this->con = mysql_connect($this->host, $this->user, $this->pwd, $this->db);
      mysql_select_db($this->db, $this->con) or die(mysql_error());
      mysql_set_charset('utf8', $this->con);
    }

    public function __destruct() {
      mysql_close($this->con);
    }

    public static function instance($host=null, $user=null, $pwd=null, $db=null) {
      if(self::$instance != null)
        return self::$instance;

      $cls = get_called_class();
      return self::$instance = new $cls($host, $user, $pwd, $db);
    }

    // @desc: sugar for mysql_query
    public function query($sql) {
      $result = mysql_query($sql, $this->con);
      if(SQL_DEBUGGING === true) {
        echo "<pre>";
        var_dump($sql);
        echo "</pre>";
      }
      return $result;
    }

    /*
      @descr: checks if a table exists
      @copied from: http://php.net/manual/en/function.mysql-tablename.php#41830
    */
    public function tableExists($table) {
      if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'")) == 1)
        return true;
      return false;
    }

  /*
   @args:
     $table / $columns: check _prepareEntitiesSql();
     $conditions: check _prepareConditionsSql();
     $orders: check _prepareOrdersSql();
     $limit: check _prepareLimitSql();
  */
    public function select($table, $conditions=null, $columns=null, $orders=null, $limit=null) {
      $query = 'SELECT {%columns%} FROM {%table%} {%conditions%} {%orders%} {%limit%}';
      $args = $this->_prepareArgs($table, $conditions, $columns, $orders, $limit);

      $query = $this->_queryTemplate($query, $args);
      $result = $this->query($query);
      return $this->_assocRows($result);
    }

    public function join($left, $right, $type, $conditions=null, $join_columns=null, $orders=null, $limit=null) {
      $query = 'SELECT {%columns%} FROM {%table_left%} as {%name_left%} {%join%} {%table_right%} AS {%name_right%} ON ({%name_left%}.{%column_left%} = {%name_right%}.{%column_right%}) {%conditions%} {%orders%} {%limit%}';
      $args = $this->_prepareArgs(null, $conditions, $join_columns, $orders, $limit);
      $join_args = $this->_prepareJoinArgs($left, $right, $type);

      $args = array_merge($args, $join_args);
      $query = $this->_queryTemplate($query, $args);

      return $this->_assocRows($this->query($query));
    }


    /*
      @desc: sugar for returning the first entry inside the select()-response
    */
    public function selectFirst($table, $conditions=null, $columns=null, $orders=null, $limit='0,1') {
      $data = $this->select($table, $conditions, $columns, $orders, $limit);
      if(count($data) > 0)
        return $data[0];
      return null;
    }

  /*
   @args:
     $table / $columns: check _prepareEntitiesSql();
     $conditions: check _prepareConditionsSql();
  */
    public function update($table, $values=null, $conditions=null) {
      $query = 'UPDATE {%table%} SET {%column_values%} {%conditions%}';
      $args = $this->_prepareArgs($table, $conditions);
      $args['column_values'] = $this->_prepareUpdateValues($values);

      $query = $this->_queryTemplate($query, $args);
      $result = $this->query($query);
      return $result;
    }

    public function delete($table, $conditions) {
      $query = 'DELETE FROM {%table%} {%conditions%}';
      $args = $this->_prepareArgs($table, $conditions);
      $query = $this->_queryTemplate($query, $args);
      $this->query($query);
    }

    public function truncate($table) {
      $query = 'TRUNCATE TABLE `' . $this->_esc($table) . '`';
      $this->query($query);
    }

    public function drop($table) {
      $query = 'DROP TABLE `' . $this->_esc($table) . '`';
      $this->query($query);
    }

    /*
      @descr: Return a fetched mysql-resource as an associative array
    */
    protected function _assocRows($resource) {
      $rows = array();

      while($row = mysql_fetch_assoc($resource))
        $rows[] = $row;

      return $rows;
    }

    /*
      @desc: Sugar for single, returns the new id
    */
    public function insertSingle($table, $data, $columns=null) {
      $this->insert($table, $data, $columns);
      return mysql_insert_id($this->con);
    }

    /*
      @desc: Insert method for sql entries.
      @args:
        $table : String

        $rows:
          Type Assoc-Array
            @desc: Contains the column-names in the keys and the values in the values
          Type Index-Array
            @desc: Contains the values, it requires columns definitions in the $args array
                    Each row has to have the same number of elements as the columns array
        $columns:
          Type Index-Array
            @desc: Contains the column-names. When tho $rows-Array is associative only the
                   row-keys which matches the columns are saved.
    */
    public function insert($table, $data, $columns=null) {
      $query = 'INSERT INTO {%table%} ({%columns%}) VALUES {%values%}';
      if(Utilities::isAssoc($data) || !is_array($data[0]));
        $data = array($data);

      if(is_array($data))
        $data_is_assoc = Utilities::isAssoc($data[0]);

      if(!$data_is_assoc && !is_array($columns))
        throw new Exception("The provided values don't contain any column definitions");

      if(!$data_is_assoc && count($data[0]) != count($columns))
        throw new Exception("The provided column definition dont match the value definition");

      if($data_is_assoc)
        $columns = array_keys($data[0]);

      $sql_columns = $this->_prepareColumnSql($columns);
      $sql_values = null;

      foreach($data as $row) {
        $i = 0;
        $row = $this->_prepareValues($row);
        $row_values = array();

        foreach($columns as $key => $column) {
          if(!$data_is_assoc)
            $row_values[] = $row[$key];
          else if(array_key_exists($column, $row))
            $row_values[] = $row[$column];
        }

        $sql_values .= (!is_null($sql_values) ? "," : "\n\t") . '(' . implode(',', $row_values) . ')';
      }

      $query = $this->_queryTemplate($query, array(
        'table' => $this->_prepareTableSql($table),
        'columns' => $sql_columns,
        'values' => $sql_values
      ));

      $this->query($query);
    }

    /*
      @def: Creates a new Table in the DB. IF no column is an ID Column is automatically generated
      @args: $table : assoc_array
             $columns : assoc_array
             $add_id_column : Boolean
             $primary_column : String, name of the column which has the primary key
    */
    public function createTable($table, $columns=null, $add_id_column=true, $primary_column=false) {
      $template = 'CREATE TABLE IF NOT EXISTS {%table%} ({%columns%} {%primary_key%}) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;' ;

      $columns = !is_array($columns) ? array() : $columns;
      if($add_id_column) {
        $primary_column = 'id';
        array_unshift($columns, array('id', 'INT(10) NOT NULL AUTO_INCREMENT'));
      }

      $column_sql = '';
      $num_cols = count($columns);
      for($i = 0; $i < $num_cols; $i++)
        $column_sql .= "\t" . $this->_prepareColumnDefinition($columns[$i]) . ($i+1 < $num_cols ? ",\n" : '');

      $query = $this->_queryTemplate($template, array(
        'table' => $this->_prepareTableSql($table),
        'columns' => "\n" . $column_sql,
        'primary_key' => $add_id_column || $primary_column ? ",\n\tPRIMARY KEY (" . $primary_column . ")\n" : "\n"
      ));

      $this->query($query);
    }


    /*
      @desc: Add collumns to a Table
      @args:
        $table : String
        $columns : array -> check _prepareColumnDefinietion();
    */
    protected function addColumns($table, $columns) {
      $template = 'ALTER TABLE {%table%} ADD COLUMN {%colum%};';
      $query = 'START TRANSACTION;';
      foreach($columns as $col) {
        $query .= $this->_queryTemplate($template, array(
          'table' => $this->_esc($table),
          'column' => $this->_prepareColumnDefinition($col)
          ));
      }
      $query .= 'COMMIT;';

      $this->query($query);
    }

    /*
      @desc: sugar for escaping mysql-String
      @trivia: Escaping the mysql_string is necessary
               in order to prevent SQL-Injection attacks
    */
    protected function _esc($term) {
      return mysql_real_escape_string($term);
    }

    /*
      @desc: Sugar for calling the
             Uilities::templateReplace method
             with the right parameters
    */
    protected function _queryTemplate($template, $args) {
      return Utilities::templateReplace($template, $args, '{%', '%}');
    }

    /*
      @def: prepares multiple arguments and returns an assoc-array

    */
    protected function _prepareArgs($table=null, $conditions=null, $columns=null, $orders=null, $limit=null) {
      return array(
        'table' => $this->_prepareTableSql($table),
        'conditions' => $this->_prepareConditionsSql($conditions),
        'columns' => $this->_prepareColumnSql($columns, '*'),
        'orders' => $this->_prepareOrdersSql($orders),
        'limit' => $this->_prepareLimitSql($limit),
      );
    }

    protected function _prepareJoinArgs($left, $right, $type='LEFT') {
      return array(
        'table_left' => $this->_prepareEntitiesSql($left[0]),
        'name_left' => $this->_prepareEntitiesSql($left[1]),
        'column_left' => $this->_prepareEntitiesSql($left[2]),
        'table_right' => $this->_prepareEntitiesSql($right[0]),
        'name_right' => $this->_prepareEntitiesSql($right[1]),
        'column_right' => $this->_prepareEntitiesSql($right[2]),
        'join' => $type . ' JOIN'
      );
    }

    /*
      @args
        $values : array('key' => 'value'
        eg. array('name' => 'ruedi');
    */
    protected function _prepareUpdateValues($values=null) {
      if(is_null($values))
        return '';


      $this->_prepareValues($values);

      if(!is_array($values))
        return '`' . $key . '` = ' . $this->_prepareValues($values);

      $sql = null;
      foreach($values as $key => $value) {
        if(!is_null($sql))
          $sql .= ' , ';

        $sql .= '`' . $key . '` = ' . $this->_prepareValues($value);
      }
      return $sql;
    }

    /*
      @args
        $col : string -> Column definition as string
        $col : array(a,b) -> Column name and column definition seperated in 2-value-array
        eg. array('category', 'VARCHAR(50)');'
    */
    protected function _prepareColumnDefinition($col=null) {
      if(is_null($col))
        return '';

      if(is_string($col))
        return $this->_esc($col);

      if(count($col) == 0)
        return '';

      if(count($col) == 1)
        return $this->_esc($col[0]);

      return $this->_esc($col[0] . ' ' . $col[1]);
    }

    /*
     @desc: Generates the limit part of a select query
     @args:
       $limit:
         Type String:
           returns "LIMIT $limit"
         Type Array:
           Length = 1
             returns "LIMIT $limit[0]"
           Length = 2
             returns "LIMIT $limit[0], $limit[1]"
    */
    protected function _prepareLimitSql($limit=null) {
      if(is_null($limit))
        return '';

      if(is_string($limit))
        return $this->_esc('LIMIT ' . $limit);

      if(count($limit) == 0)
        return '';

      if(count($limit) >= 2)
        return $this->_esc('LIMIT ' . $limit[0] . ', ' . $limit[1]);
      else
        return $this->_esc('LIMIT ' . $limit[0]);
    }

    /*
     @desc: Generates the orders part of a select query
     @args:
       $limit:
         Type String:
           returns "ORDER BY $orders"
         Type Array:
          returns "ORDER BY $limit[0],$limit[1],$limit[2],..."
    */
    protected function _prepareOrdersSql($orders=null) {
      if(is_null($orders))
        return '';

      if(is_string($orders))
        return $this->_esc('ORDER BY ' . $orders);

      $orders =  implode(', ', $orders);

      return $this->_esc('ORDER BY ' . $orders);
    }

    /*
     @desc: Generates the conditions part of a query
     @args:
       $conditions:
         Type String:
           returns "WHERE $conditions"
         Type Indexed 2D-Array: {'key1'=>'value1', 'key2'=>array('value2_1', 'value2_2')}
           @desc: each array element is concatenated by an " AND " if a value is an array its
                  values are concatenated inside a Group by an " OR "
           @args:
            array-value
              Type : String
                adds ... " AND $key == $value"
              Type : Array
                adds ... " AND ($key == $value OR $key == $value2) "

         returns "WHERE $composed_conditions"
    */
    protected function _prepareConditionsSql($conditions=null) {
      if(is_null($conditions))
        return '';

      if(is_string($conditions))
        return 'WHERE ' . $this->_esc($conditions);

      if(!is_array($conditions))
        throw new Exception('The provided conditions are not valid');

      $cond = null;
      foreach($conditions as $key => $value) {
        $key = $this->_esc($key);

        if(!is_null($cond))
          $cond .= ' AND ';

        if(is_array($value))
          $cond .= '( ';

        // This generates or-conditions, such that `id`=1 AND ( `cat`='foo' OR `cat`='bar' )
        if(is_array($value)) {
          // encase each string value with String-Apostrophes (SQL-Requirement)
          $value = $this->_prepareValues($value);
          $cond .= '`' . $key . '` = ' . implode(' OR `' . $key . '` = ',  $value);
        } else {
          $cond .= '`' . $key . '` = ' . $this->_prepareValues($value);
        }

        if(is_array($value))
          $cond .= ' )';

      }

      return 'WHERE ' . $cond;
    }

    protected function _prepareValues($values) {
      if(!is_array($values)) {
        $val = $this->_esc($values);
        $val = is_string($val) ?  "'" . $val . "'" : $val;
        return $val;
      }

      foreach($values as &$val) {
        $val = $this->_esc($val);
        $val = is_string($val) ?  "'" . $val . "'" : $val;
      }
      return $values;
    }

    // @desc: sugar for table-Entities
    protected function _prepareTableSql($value=null, $default='*') {
      return $this->_prepareEntitiesSql($value, $default);
    }

    // @desc: sugar for column-Entities
    protected function _prepareColumnSql($value=null, $default=null) {
      return $this->_prepareEntitiesSql($value, $default);
    }

    /*
      @desc: Concatenates table Entities
      @args: $default = null allows for * in cols statement
    */
    protected function _prepareEntitiesSql($value=null, $default=null) {
      if(is_null($value)) {
        if(!is_null($default))
          return $default;
        else
          throw new Exception('No Entity defined for SQL-Query');
      }

      if(!is_array($value))
        $value = array($value);

      $result = '';
      $add = '';
      foreach($value as $val) {
        $val = trim($val);
        if(preg_match("/^([a-zA-Z][a-zA-Z0-9_-]*)(\.?)([a-zA-Z][a-zA-Z0-9_-]*)\s+([aA][sS]\s+)?([a-zA-Z][a-zA-Z0-9_-]*)$/", $val)) {
          $add = preg_replace("/^([a-zA-Z][a-zA-Z0-9_-]*)(\.?)([a-zA-Z][a-zA-Z0-9_-]*)\s+([aA][sS]\s+)?([a-zA-Z][a-zA-Z0-9_-]*)$/", '`$1`$2`$3` $4 `$5`', $val) . ' ';
        } else if(preg_match("/^([a-zA-Z][a-zA-Z0-9_-]*)\s+([aA][sS]\s+)?([a-zA-Z][a-zA-Z0-9_-]*)$/", $val)) {
          $add = preg_replace("/^([a-zA-Z][a-zA-Z0-9_-]*)\s+([aA][sS]\s+)?([a-zA-Z][a-zA-Z0-9_-]*)$/", '`$1` $4 `$5`', $val) . ' ';
        } else if(preg_match("/^([a-zA-Z][a-zA-Z0-9_-]*)(\.)([a-zA-Z][a-zA-Z0-9_-]*)$/", $val)){
          $add = preg_replace("/^([a-zA-Z][a-zA-Z0-9_-]*)(\.)([a-zA-Z][a-zA-Z0-9_-]*)$/", '`$1`$2`$3`', $val) . ' ';
        } else {
          $add = '`' . $val . '`';
        }
        $result .= $result == '' ? $add : ', ' . $add;
      }

      return $result;
    }

  }
?>