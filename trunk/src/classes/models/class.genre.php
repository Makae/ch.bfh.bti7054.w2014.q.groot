<?php
  class GenreModel extends BaseModel {
    protected static $TABLE = 'genre';
    protected static $COLUMN_NAMES = array('key');
    protected static $COLUMN_TYPES = array('VARCHAR(50) UNIQUE NOT NULL');

    public static function getTranslatedGenres() {
      $list = static::findList(null, array('id', 'key'));
      $genres = array();
      foreach($list as $row)
        $genres[] = array('value' => $row['id'], 'label' => i('db_genre_key_' . $row['key']));

      return $genres;
    }

  }
?>