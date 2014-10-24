<?php
  class BookModel extends BaseModel {
    protected static $TABLE = 'book';
    protected static $COLUMN_NAMES = array('name', 'isbn');
    protected static $COLUMN_TYPES = array('VARCHAR(50) NOT NULL', 'VARCHAR(32) NOT NULL');

  }
?>