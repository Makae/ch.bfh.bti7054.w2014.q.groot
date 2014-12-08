<?php
  class GenreModel extends BaseModel {
    protected static $TABLE = 'genre';
    protected static $COLUMN_NAMES = array('key');
    protected static $COLUMN_TYPES = array('VARCHAR(50) UNIQUE NOT NULL');

  }
?>