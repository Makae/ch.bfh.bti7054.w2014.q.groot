<!-- Autor: Fabian Schwab -->
<!-- Zweck: ShoppingCart Item, welches verwendet wird, um anzuzeigen, welche Items in den Cart gelegt wurden und diese zu verwalten -->

<?php

class ShoppingCart {
	
	const classInfo = "WARENKORB";
	private	$items = array();
	private $totalPrice=0;
	private $userID = "";

	public function doit() {
		return true;
	}
	
	public function getUserID() {
		return $this->userID; }
		
	public function setUserID($userID) {
		$this->userID = $userID;
	}
	
	//Add a ShoppingcartItem - Einfach Items aus einer Klasse zu machen als multidimensinale Arrays zu bruachen

	public function addItem($ID, $price, $quant) { //Artikel und - in seinem Beispiel - die Anzahl der Items/Artikel
		/*Falls es den Artikel noch nicht gibt, muss die Stelle im assoziativen Array zuerst initialisiert werden
		Bsp. items['5'] //für Artikel 5 muss zuerst initialisiert werden mit 0 damit dannn damit gearbeitet werden kann
		*/
		$itemToAdd = new Item($ID, $price, $quant);
		//echo "Item erstellt:".var_dump($itemToAdd);
		
		
		if(!isset($this->items[$itemToAdd->ID])) {//wenn es mit dieser ID noch keinen Eintrag hat, initialisieren und dann hinzufügen
			echo "Neues Item";
			$this->items[$itemToAdd->ID]=0;
			$this->items[$itemToAdd->ID]=$itemToAdd;
		}
		else { //Wenn es es schon gab, die Items "mergen"
			echo "Item schon drin, wird angepasst<br>";
			echo "".$this->items[$itemToAdd->ID]->quantity." war vor dem hinzufügen die Quantity";
			
			$this->items[$itemToAdd->ID]->quantity+=$itemToAdd->quantity;
			echo "".$this->items[$itemToAdd->ID]->quantity." ist nun nach hinzufügen die Quantity";
	 } 	

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
	
	public function display() { //Anzeigen mit einer Table - echo gibt die Sachen gleich aus, man braucht keinen Return Wert

	//Hinter jeden Eintrag noch einen Remove Button

	$lan = $_COOKIE["language"];
	
	if(sizeof($this->items)==0)
		echo "Ihr Warenkorb ist leer";

	else		{
		
		echo "In ihrem Warenkorb befinden sich folgende Produkte:<br><br><br>";
		echo "<table border='1'>";
		echo "<tr id='tableTopics'><td>Artikel-Nr.</td><td>Anzahl</td><td>Preis</td>";
		foreach ( $this->items as $index => $value ) { //$value ist neu das ItemObjekt
			$subtotal = $value->quantity * $value->price;
			
			echo "<tr><td>$index</td><td>$value->quantity</td><td>$subtotal</td>";
			
			echo "<td><form action='index.php?view=addToCart&lan=$lan' method='post'><input type='submit' value='Remove'></input><input type='hidden' name='delete' value='$index'></input></form></td></tr>";
		}
		$price = $this->calculatePrice();
		
		echo "<tr></tr>";
		echo "<tr><td></td><td></td><td>Total</td>";
		echo "<tr><td></td><td></td><td>$price</td>";
		echo "</table>";
		
	}
	
	}
	
}
?>