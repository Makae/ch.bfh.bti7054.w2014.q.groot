<?php
  class BookModel extends BaseModel {
    protected static $TABLE = 'book';
    protected static $COLUMN_NAMES = array(
    	'name', 
    	'isbn',
    	'Title',
    	'Year_of_publication',
    	'Price',
    	'Currency',
    	'Available',
    	'Language',
    	'Description',
    	'Original_language',
    	'Number_of_Pages',
    	'Version',
    	'Type',
    	'Genre'
    	);
    protected static $COLUMN_TYPES = array(
    	'VARCHAR(50) NOT NULL', 
    	'VARCHAR(32) NOT NULL',
    	'VARCHAR(150) ',
    	'INT(32) ',
    	'FLOAT',
    	'VARCHAR(32) ',
    	'VARCHAR(32) ',
    	'VARCHAR(60) ',
    	'VARCHAR(200) ',
    	'VARCHAR(5000) ',
    	'VARCHAR(32) ',
    	'INT(32) ',
		'FLOAT',
		'VARCHAR(60) ',
		'VARCHAR(60) '
    	);

  }
?>