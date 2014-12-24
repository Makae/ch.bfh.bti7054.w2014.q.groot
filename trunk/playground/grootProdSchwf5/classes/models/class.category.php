<?php
  class CategoryModel extends BaseModel {
    protected static $TABLE = 'category';
    protected static $COLUMN_NAMES = array('key', 'description', 'lang');
    protected static $COLUMN_TYPES = array('VARCHAR(50) NOT NULL', 'TEXT', 'VARCHAR(2) NOT NULL');

    public function lang() {
      return $this->data['lang'];
    }

  }
?>