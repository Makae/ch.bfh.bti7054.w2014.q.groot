<?php
  class UserModel extends BaseModel {
    protected static $TABLE = 'user';
    protected static $COLUMN_NAMES = array('user_name',
                                           'first_name',
                                           'last_name',
                                           'password',
                                           'lang',
                                           'isAdmin');
    protected static $COLUMN_TYPES = array('VARCHAR(20) UNIQUE NOT NULL',
                                           'VARCHAR(50) NOT NULL',
                                           'VARCHAR(50) NOT NULL',
                                           'VARCHAR(32) NOT NULL',
                                           'VARCHAR(2) NOT NULL',
                                           'BOOLEAN DEFAULT false');

    public function lang() {
      return $this->data['lang'];
    }

  }
?>