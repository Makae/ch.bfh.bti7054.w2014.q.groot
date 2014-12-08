<?php
  class TypeModel extends BaseModel {
    protected static $TABLE = 'type';
    protected static $COLUMN_NAMES = array('key', 'name', 'lang');
    protected static $COLUMN_TYPES = array('VARCHAR(40) NOT NULL', 'VARCHAR(200) NOT NULL', 'VARCHAR(2) NOT NULL');

	public function lang() {
      return $this->data['lang'];
    }
  }
?>