<?php
  class BookgenreModel extends BaseModel {
    protected static $TABLE = 'bookgenre';
    protected static $COLUMN_NAMES = array('book_id', 'genre_id');
    protected static $COLUMN_TYPES = array('VARCHAR(10) NOT NULL', 'VARCHAR(10) NOT NULL');
  }
?>