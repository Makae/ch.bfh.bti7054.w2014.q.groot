<?php
  class OrderModel extends BaseModel {
    protected static $TABLE = 'order';
    protected static $COLUMN_NAMES = array('user_id', 'datetime');
    protected static $COLUMN_TYPES = array('INT(10) NOT NULL', 'DATETIME NOT NULL');

  }
?>