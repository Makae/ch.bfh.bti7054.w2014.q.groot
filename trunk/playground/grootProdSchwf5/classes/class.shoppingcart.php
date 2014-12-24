<?php

class ShoppingCart {

	const classInfo = "shoppingCart";
	
	private	$items = array();
	private $totalPrice=0;
	private $userID = "";

	function __construct($carArray) {
		$this->items = $carArray;	
	}
	
	
	public function getUserID() {
		return $this->userID; }

		public function setUserID($userID) {
			$this->userID = $userID;
	}

		
	public function emptyCart() {
			$this->items=array();
		}


	 public function removeItemCompletely($ID) {
	 	unset($this->items[$ID]);
	 }

	 public function removeItem($ID, $quant) {

	 	if($this->items[$ID]==0 || $this->items[$ID]<$quant)
	 		return false;
	 	else {
	 		$this->items[$ID]-=$quant;
				if($this->items[$ID]==0)
					unset($this->items[$ID]);	//Unsetten, damit es dann im Warenkorb nicht als Artikel erscheint mit Quantity '0'
				return true;
	 	}
	 }

	 public function calculatePrice() {
	 	$totalPrice = 0;
	 	foreach($this->items as $ID=>$itemObject) { //foreach loop für assoziatives array: Index und dann den Wert mit => auflösen
	 		$totalItemPrice = $itemObject->price * $itemObject->quantity;
	 		$totalPrice +=$totalItemPrice;
	 	}
	 	return $totalPrice;
	 }

	 
	 public function displayCart() {
	 	
	 	$table ="";
	 	$table = "<br>In ihrem Warenkorb befinden sich: ".sizeof($this->items)." Elemente".
	 	 	"<table border='1'>".
	 	 	"<tr id='tableTopics'><td>Artikel-Nr.</td><td>Anzahl</td><td>Preis</td>";
	 	 	
	 	 	foreach ( $this->items as $index) {		
			$ID2del=$index->ID;
	 	 	$table= $table."<tr><td>$index->ID</td><td>$index->amount</td>
	 	 	<td></td>
	 	 	<td><form action='http://localhost/grootprod/index.php?view=shoppingcart&remove=$ID2del' method='post'><input type='submit' value='Remove'></input></form>
	 	 	</td>
	 	 	</tr>"; 
	 	 		 	 	}
	 	
	 	$table= $table."</table>
	 			<form action='index.php?view=shoppingcart' method='post'>
	 			<input type='submit' value='Empty Cart'></input>
	 			<input type='hidden' name='clearCart'></input></form>";

	 	return $table;
	 	
	 	
	 }
	 
	 public function displayTest() {
	 	$table ="";
	 	$table = "<br>In ihrem Warenkorb befinden sich: ".sizeof($this->items)." Elemente".
	 			"<table border='1'>".
	 			"<tr id='tableTopics'><td>Artikel-Nr.</td><td>Anzahl</td><td>Preis</td>";
	 	
	 	foreach ( $this->items as $index) {
	 		$table= $table."<tr><td>$index->ID</td><td>$index->amount</td><td></td>
	 		<td>
	 		<form action='index.php' method='post'><input type='submit' value='Remove'></input>
	 		</form>
	 		</td></tr>"; 
	 	}
	 		
	 	$table= $table."</table>";
	 	
	 	return $table;

}
}

?>