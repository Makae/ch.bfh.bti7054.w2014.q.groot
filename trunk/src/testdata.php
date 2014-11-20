<?php
  $db = Core::instance()->getDb();
  if(isset($_REQUEST['clear_tables']) && $_REQUEST['clear_tables'] == true) {
    $db->drop('user');
    $db->drop('book');
    $db->drop('order');
    $db->drop('position');
  }

  if(!$db->tableExists('user')) {
    UserModel::create(array(
      'user_name' => 'tony',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Tony',
      'last_name' => 'Stark',
      'lang' => 'de'
    ));
    UserModel::create(array(
      'user_name' => 'hulk',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Bruce',
      'last_name' => 'Banner',
      'lang' => 'de'
    ));
    UserModel::create(array(
      'user_name' => 'thor',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Thor',
      'last_name' => 'Odinsson',
      'lang' => 'de'
    ));
  }

  // TESTS für JOIN
  // BookModel::create(array(
  //   'name' => "My Book",
  //   'isbn' => "asofuz9p24griugr"
  // ));

  // OrderModel::create(array(
  //   'user_id' => 1,
  //   'datetime' => "2014-11-11 11:11:11"
  // ));

  // PositionModel::create(array(
  //   'order_id' => 1,
  //   'book_id' => 1,
  //   'amount' => 1,
  //   'price' => 12.50
  // ));

  // echo "<pre>";
  // die(var_dump(OrderPositionJoin::find()));

?>