<?php
  class CategoryModel extends BaseModel {
    protected static $TABLE = 'category';
    protected static $COLUMN_NAMES = array('key', 'name', 'lang');
    protected static $COLUMN_TYPES = array('VARCHAR(50) NOT NULL', 'VARCHAR(50) NOT NULL', 'VARCHAR(2) NOT NULL');

  }
?>