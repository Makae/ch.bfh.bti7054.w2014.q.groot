<?php
  abstract class BaseModel {
    const DATA_UNDEF = 1;
    const DATA_DRAFT = 2;
    const DATA_DB    = 3;

    protected static $TABLE = null;
    // Please notice, the ID column is automatically generated by the db class
    protected static $COLUMN_NAMES = array();
    // The number of the column types has to exactly match the number of the column names
    // because they are later combined when creating the database table
    protected static $COLUMN_TYPES = array();
    // Those keys are ignored when setting data
    protected static $IGNORE_KEYS = array('id');

    // defines the status of the data and if it has already an id / version in the db
    protected  $data_status = BaseModel::DATA_UNDEF;
    // associative array. The keys in this arrays correspondent to the $COLUMN_NAMES-values
    protected $data;

    /*
      @desc: Constructor of loading data in the model
      @args: Either provid id XOR $data
        $id : int -> id in the database
        $data : array -> data to load into th data array
                this does not create a new entry in the db
                use Model::create($data) instead
    */
    public function __construct($id=null, $data=null) {
      static::_initTable();

      if(is_null($id) && is_null($data) || !is_null($id) && !is_null($data))
        throw new Exception("Can not instantiate Model, please provid id or data");

      $db = Core::instance()->getDb();
      if(!is_null($id)) {
        // Can't use static::findFirst, or it will result in endless recursion
        $data = Core::instance()->getDb()->selectFirst(static::$TABLE, array('id' => $id));
        $this->data_status = BaseModel::DATA_DB;
      }
      else {
        foreach($data as $key)
          if(in_array($key, static::$IGNORE_KEYS))
            unset($data[$key]);

        $this->data_status = BaseModel::DATA_DRAFT;
      }

      if($data == null)
        return null;

      $this->data = $data;
    }


    /*
      @desc: instantiates a child instance from the BaseModel-Class
      @return: if the id is not found or not defined null is returned
               else an instance of the child class
    */
    protected static function childInstance($id=null) {
      if($id == null)
        return null;

      $cls = get_called_class();
      return new $cls($id);
    }

    /*
      @desc: creates and saves a new Model to the data,
             returns the a new Instance of the model
    */
    public static function create($data) {
      static::_initTable();

      foreach(static::$IGNORE_KEYS as $key)
        if(array_key_exists($key, $data))
          unset($data[$key]);


      $id = Core::instance()->getDb()->insertSingle(static::$TABLE, $data, static::$COLUMN_NAMES);
      return static::childInstance($id);
    }

    public static function find($conditions) {
      static::_initTable();
      static::_validateColumns($conditions);

      $result = Core::instance()->getDb()->select(static::$TABLE, $conditions, array('id'));

      $return = array();
      foreach($result as $data)
        $return[] = static::childInstance($data['id']);
      return $return;
    }

    public static function findFirst($conditions) {
      static::_initTable();
      static::_validateColumns($conditions);
      $data = Core::instance()->getDb()->selectFirst(static::$TABLE, $conditions, array('id'));
      return static::childInstance($data['id']);
    }

    /*
      @descr: updates the data of the model in the database.
              if not already in the db the model-data is now added.
    */
    public function update($data=null) {

      if(is_array($data))
        $this->setData($data);

      if($this->data_status != BaseModel::DATA_DB) {
        $this->_saveUpdate();
        return;
      }

      $data = $this->data;
      foreach(static::$COLUMN_NAMES as $column)
        if(!array_key_exists($column, $data) || !array_key_exists($column, static::$IGNORE_KEYS))
          unset($data[$key]);

      Core::instance()->getDb()->update(static::$TABLE, $data, array(
        'id' => $this->id()
      ));

    }

    public function delete() {
      static::_initTable();

    }

    public function id() {
      return $this->data['id'];
    }

    public function getData() {
      return $this->data;
    }

    public function getValue($key) {
      if(array_key_exists($key, $this->data))
        return $this->data[$key];
    }

    public function setData($data) {
      foreach($this->data as $key => $value)
        $this->setValue($key, $value);
    }

    public function setValue($key, $value) {
      if(in_array($key, static::$IGNORE_KEYS))
        return;
      $this->data[$key] = $data[$key];
    }

    /*
      @descr: has to be called by all static methods
              to ensure the table exists
    */
    private static function _initTable() {
      $db = Core::instance()->getDb();

      if($db->tableExists(static::$TABLE))
        return;

      $db_columns = array();

      foreach(static::$COLUMN_NAMES as $key => $col)
        $db_columns[] = array($col, static::$COLUMN_TYPES[$key]);

      $db->createTable(static::$TABLE, $db_columns);
    }

    /*
      @desc: Saves the current data vai the Model::create() method
             and updates the data and data_status properties
    */
    private function _saveUpdate() {
      $instance = static::create($this->data);
      $this->data = $instance->getData();
      $this->data_status = BaseModel::DATA_DB;
    }

    private static function _validateColumns($columns) {
      foreach($columns as $key => $value)
        if(!in_array($key, static::$IGNORE_KEYS) && !in_array($key, static::$COLUMN_NAMES))
          throw new Exception("The requested column " . static::$TABLE . "::$key in BaseModel::find does not exist");
    }

  }
?>