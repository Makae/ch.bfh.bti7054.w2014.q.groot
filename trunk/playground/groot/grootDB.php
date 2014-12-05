<?php

class grootDB extends mysqli {
	
//Wenn man keinen Konstruktor in der Childklasse definiert, wird automatisch der Parentkonstruktor aufgerufen.
//Will man den modden, dann muss man einen eigenen Konstruktor in der Childklasse schreiben und darin u.A. den Konstruktor der Parentklasse aufrufen.

function __construct() {
	parent::__construct('localhost', 'root', '', 'grootDB');
	//sonst noch mit parent::select_db("grootDB"); die gewünschte DB selektieren
}


public function getGenres() {
	
	$result = $this->query("SELECT * FROM genre");
	return $result;
}



	/*BOOK

+-------------+---------------+------+-----+---------+----------------+
| Field       | Type          | Null | Key | Default | Extra          |
+-------------+---------------+------+-----+---------+----------------+
| id          | int(11)       | NO   | PRI | NULL    | auto_increment |
| title       | varchar(50)   | NO   |     | NULL    |                |
| genre_id    | int(11)       | NO   | MUL | NULL    |                |
| isbn        | varchar(50)   | YES  |     | NULL    |                |
| year        | int(11)       | YES  |     | NULL    |                |
| price       | float         | YES  |     | NULL    |                |
| author      | varchar(30)   | YES  |     | NULL    |                |
| pages       | int(11)       | YES  |     | NULL    |                |
| type        | int(11)       | YES  | MUL | NULL    |                |
| description | varchar(1000) | YES  |     | NULL    |                |
+-------------+---------------+------+-----+---------+----------------+

	 */

	public function deleteBook($title) {
		
		if($this->query("DELETE FROM book WHERE title='$title'"))
			echo "Buch gelöscht";		
	}

	public function getTitles() {
		//gibt gleich ein Array mit den titeln zurück
		$res = $this->query("SELECT title FROM book");
		$array = array();
		while($title = $res->fetch_object()){
			array_push($array, $title->title);		
		}
		echo "Array mit titeln gebaut. Anzahl Titel: ". sizeof($array);
		return $array;
	}

	public function getAllBooks() {
		//gibt ein Resultobjekt zurück
		return $this->query("SELECT * FROM book");		
	}

	public function addBook($title, $genre, $isbn, $year, $price, $author, $pages, $description) {

		
		$res = $this->query("SELECT * FROM genre WHERE name='$genre'");
		if($res)
		$genreID =  $res->fetch_object()->id;

		$result = $this->query("INSERT INTO book VALUES('DEFAULT', '$title', '$genreID', '$isbn', '$year', '$price', '$author', '$pages', 1, '$description')");
		if(!$result) {
			echo "Fehler: ".$this->error;
		}
		else {
			//Updaten
			
			return $result;
		}
	}
	
	
	
	
	//Hier auch noch mit wählbarem type
	public function insertBook($title, $genre, $isbn, $year, $price, $author, $pages, $type, $description) {
		return $this->query("INSERT INTO book VALUES('DEFAULT', $title, $genre, $isbn, $year, $price, $author, $pages, $type, $description)");
		
	}
	



	public function addOrder($userid, $shipping, $payment, $notes) {
		
		/* ORDERTABLE: Enthält die Bestellungen, die ihrerseits aus verschiedenen Positionen bestehen
		
		+----------+--------------+------+-----+---------+----------------+
		| Field    | Type         | Null | Key | Default | Extra          |
		+----------+--------------+------+-----+---------+----------------+
		| id       | int(11)      | NO   | PRI | NULL    | auto_increment |
		| user_id  | int(11)      | NO   | MUL | NULL    |                |
		| date     | date         | YES  |     | NULL    |                |
		| shipping | varchar(15)  | YES  |     | NULL    |                |
		| payment  | varchar(15)  | YES  |     | NULL    |                |
		| notes    | varchar(200) | YES  |     | NULL    |                |
		+----------+--------------+------+-----+---------+----------------+
		
		*/
		
		echo $currentDay = date('Y-m-d');
		$success = $this->query("INSERT INTO ordertable VALUES(NULL, '1', '$currentDay', '$shipping', '$payment', '$notes')");

				
		if($success) {
			$this->commit();
			echo "Eingetragen";
		}
		else {
			echo "NOK - Fehler:<br>"; //Wenn es einen Fehler beim Eintragen gab, gebe ich diesen mit der geerbten Funktion error aus
			echo $this->error; //Error ist eine Stringvariable. 
		}
	}
	


	public function addPosition($orderID, $bookID, $amount, $price) {
		/* position - table:
		 +----------+---------+------+-----+---------+-------+
		| Field    | Type    | Null | Key | Default | Extra |
		+----------+---------+------+-----+---------+-------+
		| order_id | int(11) | NO   | PRI | NULL    |       |
		| book_id  | int(11) | NO   | PRI | NULL    |       |
		| amount   | int(11) | YES  |     | NULL    |       |
		| price    | float   | YES  |     | NULL    |       |
		+----------+---------+------+-----+---------+-------+
		*/
	
		$this->query("INSERT INTO position VALUES(", $query);
	
	}


public function addAccount($username, $password, $fname, $sname) {
	
	/*
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| id       | int(11)     | NO   | PRI | NULL    | auto_increment |
| username | varchar(12) | NO   |     | NULL    |                |
| password | varchar(20) | NO   |     | NULL    |                |
| fname    | varchar(20) | NO   |     | NULL    |                |
| sname    | varchar(20) | NO   |     | NULL    |                |
+----------+-------------+------+-----+---------+----------------+

	 */
	
	$success = $this->query("INSERT INTO accounts VALUES('$username', '$password', '$fname', '$sname')");
	
	
	if($success) {
		$this->commit();
		//echo "Eingetragen";
	}
	else {
		echo "NOK - Fehler:<br>"; //Wenn es einen Fehler beim Eintragen gab, gebe ich diesen mit der geerbten Funktion error aus
		echo $this->error; //Error ist eine Stringvariable.
		}
	}
	
public function checkCredentials($username, $password) {
	
	echo "übergebenes user/pw combo:".$username . " ". $password;
	$result = $this->query("SELECT password FROM accounts WHERE username='$username'");
	echo "NOK";
	
	$pwObject = $result->fetch_object();
	$pw = $pwObject->password;
	
	if($password == $pw) {
		echo "Auth. OK";
		return true;
	}
	else {
		echo "Falsches Passwort";
		echo "Korrekt wäre: ".$pw;
		return false;
	}
}
	
}




?>