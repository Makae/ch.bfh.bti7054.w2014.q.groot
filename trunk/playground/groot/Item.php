<?php
class Item {
	
	public $ID;
	public $price;
	public $quantity;
	
	function __construct($ID, $price, $quantity) {
		$this->ID = $ID;
		$this->price = $price;
		$this->quantity = $quantity;
	}
		
}

?>