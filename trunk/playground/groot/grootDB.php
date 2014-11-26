<?php

class grootDB extends mysqli {
	
	
	//Hier drinn, dann die mysqli Befehle überschreiben respektive Funktionen schreiben
	//wie beispielsweise getAllBooks(), damit die gleich das machen, was wir wollen und wir nicht immer
	//die SQL Commands eingeben müssen
	
	//wenn man von grootDB eine Instanz macht, dann automatisch auch von mysqli
	
	/*
	 * BOOK

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
	
	
	
	public function getAllBooks() {
		//gibt ein Resultobjekt zurück
		return $this->query("SELECT * FROM book");		
	}

	public function insertBook($title, $genre, $isbn, $year, $price, $author, $pages, $type, $description) {
		return $this->query("INSERT INTO book VALUES('DEFAULT', $title, $genre, $isbn, $year, $price, $author, $pages, $type, $description)");
	}
	


	/* ORDERTABLE
	
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
	public function addOrder($userid, $shipping, $payment, $notes) {
		//INSERT INTO ordertable VALUES(NULL, 1, '2012-12-09', 'traiddn', 'cash', 'lorem'); OHNE FEHLER IN CONSOLE
		
		echo select * fr$currentDay = date('Y-m-d');
		$success = $this->query("INSERT INTO ordertable VALUES(NULL, $userid, $currentDay, $shipping, $payment, $notes)");
		
		if($success)
			echo "Eingetragen";
		else 
			echo "NOK";
		
	}
	
	public function addPosition() {
		
	}


















}



?>