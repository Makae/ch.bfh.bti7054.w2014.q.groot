<?php
  class TypeModel extends BaseModel {
    protected static $TABLE = 'type';
    protected static $COLUMN_NAMES = array('id', 'key', 'name');
    protected static $COLUMN_TYPES = array('VARCHAR(50) UNIQUE NOT NULL', 'VARCHAR(200) NOT NULL', 'VARCHAR(200) NOT NULL');

	public function lang() {
      return $this->data['lang'];
    }
  }
?>