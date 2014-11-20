<?php
  class PositionModel extends BaseModel {
    protected static $TABLE = 'position';
    protected static $COLUMN_NAMES = array('order_id', 'book_id', 'amount', 'price');
    protected static $COLUMN_TYPES = array('INT(10) NOT NULL', 'INT(10) NOT NULL', 'INT(2) NOT NULL', 'FLOAT NOT NULL');

  }
?>