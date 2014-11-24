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
    UserModel::create(array(
      'user_name' => 'max',
      'password' => Utilities::hash('12345', USER_SALT),
      'first_name' => 'Max',
      'last_name' => 'Muster',
      'lang' => 'en'
    ));
  }

<<<<<<< Updated upstream
  // TESTS für JOIN
  BookModel::create(array(
    'name' => "My Book",
    'isbn' => "D2342f3i",
    'Title' => "Kennzahlen aus der Wirtschaft",
    'Year_of_publication' => 1998,
    'Price' => 43.10,
    'Currency' => "CHF",
    'Available' => "Sofort",
    'Language' => "Deutsch",
    'Description' => "Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text Hier ist ein Lorem Ipsum Text ",
    'Original_language' => "Englisch",
    'Number_of_Pages' => 1872,
    'Version' => 1.2,
    'Type' => "Taschenbuch",
    'Genre' => "Krimi"
  ));


if(!$db->tableExists('bookcategory')) {
    BookcategoryModel::create(array(
      'description' => 'Taschenbuch',
      'lang' => 'de'
    ));
    BookcategoryModel::create(array(
      'description' => 'Hörspiel',
      'lang' => 'de'
    ));
    BookcategoryModel::create(array(
      'description' => 'E-Book',
      'lang' => 'en'
    ));
    BookcategoryModel::create(array(
      'description' => 'Hardcover',
      'lang' => 'de'
    ));
    BookcategoryModel::create(array(
      'description' => 'Prospekt',
      'lang' => 'de'
    ));
  }


if(!$db->tableExists('bookgenre')) {
    BookgenreModel::create(array(
      'description' => 'Science',
      'lang' => 'en'
    ));
    BookgenreModel::create(array(
      'description' => 'Fantasy',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Krimi',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Kinderbuch',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Horror',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Kunst',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Sport',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Roman',
      'lang' => 'de'
    ));
    BookgenreModel::create(array(
      'description' => 'Comic',
      'lang' => 'de'
    ));
  }
  OrderModel::create(array(
    'user_id' => 1,
    'datetime' => "2014-11-11 11:11:11"
  ));

  PositionModel::create(array(
    'order_id' => 1,
    'book_id' => 1,
    'amount' => 1,
    'price' => 12.50
  ));

  //echo "<pre>";
  //die(var_dump(OrderPositionJoin::find()));
=======
  if(!$db->tableExists('book')) {
    BookModel::create(array(
      'name' => 'alpha',
      'isbn' => 'isbn_alpha'
    ));
    BookModel::create(array(
      'name' => 'beta',
      'isbn' => 'isbn_beta'
    ));
    BookModel::create(array(
      'name' => 'gamma',
      'isbn' => 'isbn_gamma'
    ));
  }

  if(!$db->tableExists('category')) {
    CategoryModel::create(array(
      'key' => 'alpha',
      'name' => 'alpha',
      'lang' => 'de'
    ));
    CategoryModel::create(array(
      'key' => 'alpha',
      'name' => 'alpha_fr',
      'lang' => 'fr'
    ));
    CategoryModel::create(array(
      'key' => 'beta',
      'name' => 'beta',
      'lang' => 'de'
    ));
    CategoryModel::create(array(
      'key' => 'gamma',
      'name' => 'gamma_fr',
      'lang' => 'fr'
    ));
  }
>>>>>>> Stashed changes

?>