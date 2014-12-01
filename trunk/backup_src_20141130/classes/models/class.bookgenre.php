<?php
  class BookgenreModel extends BaseModel {
    protected static $TABLE = 'bookgenre';
    protected static $COLUMN_NAMES = array('description',
                                           'lang');
    protected static $COLUMN_TYPES = array('VARCHAR(200) UNIQUE NOT NULL',
      'VARCHAR(32) NOT NULL');

    public function lang() {
      return $this->data['lang'];
    }

  }
?>