<?php
class Item {
	
	private $title;
	private $ID;
	private $price;
	
	function __construct($ID, $title, $price) {
		$this->title = $title;
		$this->ID = $ID;
		$this->price = $price;
	}
	
	
}

?>