<?php

class ShoppingCart {
	
	private	$items = array();
	private $totalPrice=0;

	public function doit() {
		return true;
	}
	
	public function addItem($ID, $quant) { //Artikel und - in seinem Beispiel - die Anzahl der Items/Artikel
		/*Falls es den Artikel noch nicht gibt, muss die Stelle im assoziativen Array zuerst initialisiert werden
		Bsp. items['5'] //für Artikel 5 muss zuerst initialisiert werden mit 0 damit dannn damit gearbeitet werden kann
		*/
		if(!isset($this->items[$ID])) {
			$this->items[$ID]=0;
			$this->items[$ID]+=$quant;
		}
		else 
			$this->items[$ID]=$quant;
		
	 } 	

      	
      	/*
      	There are two ways to create an associative array: 

		$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
			or:

		$age['Peter'] = "35";
		$age['Ben'] = "37";
		$age['Joe'] = "43"; 
      	  
      	 */
   
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
		foreach($this->items as $article=>$quantity) { //foreach loop für assoziatives array: Index und dann den Wert mit => auflösen
			$totalPrice += $quantity;
		}
		return $totalPrice;
	}
	
	public function display() { //Anzeigen mit einer Table - echo gibt die Sachen gleich aus, man braucht keinen Return Wert

	//Hinter jeden Eintrag noch einen Remove Button

	$lan = $_COOKIE["language"];
	
		
		echo "In ihrem Warenkorb befinden sich folgende Produkte:<br><br><br>";
		
		echo "<table border='1'>";
		echo "<tr><td>Artikel-Nr.</td><td>Anzahl</td>";
			foreach ($this->items as $index=>$value) {
				
				echo "<tr><td>$index</td><td>$value</td><td><form action='index.php?view=addToCart&lan=$lan' method='post'><input type='submit' value='Remove'></input><input type='hidden' name='delete' value='$index'></input></form></td></tr>";
				
			}
		
		
		
		echo "</table>";
	}
	
}
?>