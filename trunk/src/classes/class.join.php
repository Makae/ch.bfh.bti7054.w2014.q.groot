<?php
  abstract class Join {
    const JOIN_LEFT = 'LEFT';
    const JOIN_RIGHT = 'LEFT';
    const JOIN_OUTER = 'OUTER';
    const JOIN_INNER = 'INNER';
    const JOIN_LINNER = 'LEFT INNER';
    const JOIN_RINNER = 'RIGHT INNER';

    // JoinRelation::JOIN_LEFT
    protected static $JOIN_TYPE;
    // array('Model', 'join_column', 'table_name_for_join')
    protected static $CONFIG_LEFT;
    protected static $CONFIG_RIGHT;

    public function find($conditions=null) {
      $result = DB::instance()->join(static::$CONFIG_LEFT, static::$CONFIG_RIGHT, static::$JOIN_TYPE, $conditions);
      return $result;
    }
  }
?>