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

	 	$TID=0;

	 	if(sizeof($this->items)==0)
	 		return "Your shopping cart is empty.";



	 	$table ="";
	 	$table = "<p>In ihrem Warenkorb befinden sich: ".sizeof($this->items)." Elemente</p>".
	 	 	"<table id='shoppingTable'>".
	 	 	"<tr id='tableTopics'><td>Artikel-Nr.</td><td>Anzahl</td><td></td><td></td><td>Preis</td><td></td>";

	 	 	foreach ( $this->items as $index) {
			$ID2del=$index->ID;
	 	 	$table= $table."<tr id=$TID onclick=''><td>$index->ID</td><td name='amount'>$index->amount</td>
	 	 	<td>
	 	 	<input type='button' id='plusButton' value='+'></input></td>
	 	 	<td><input type='button' id='minusButton' value='-'></input></td>
	 	 	<td></td>
	 	 	<td><form action='" . Controller::instance()->getViewUrl('shoppingcart') . "&remove=$ID2del' method='post'><input type='submit' value='Remove'></input></form></td>
	 	 	</tr>";

	 	 	$TID++;
	 	 	}

	 	$table= $table."</table>
	 			<form action='index.php?view=shoppingcart' method='post' class='clear-form'>
	 			<input type='submit' value='Empty Cart' class='button button-primary'></input>
	 			<input type='hidden' name='clearCart'></input></form>";

	 	//Hier den JavascriptCode rein: Erhöhen liest Anzahl aus, zählt eins dazu und reloaded the page mit dem GET Paramter: &update=ID&Amount=NEUER AMOUNT
	 	$table=$table."
	 			<script type='text/javascript'>

	 			var theTbl = document.getElementById('shoppingTable');
	 			var rows = theTbl.rows;

				console.log(rows.length);

				for(var i=0;i<rows.length;i++) {

   				 			for(var j=0;j<rows[i].cells.length;j++)	{
	 						console.log('set');
      			  				rows[i].cells[j].onclick = alertInnerHTML;
	 						}
				}

	 			rowIndex = 0;

	 			function myFunction(x) {
	 			rowIndex = x.rowIndex
	 			window.alert(rowIndex)

				}

	 			function alertInnerHTML(e) {
   					 e = e || window.event;//IE
	 				rownumber = this.parentNode.id;
	 				cellNumber = this.cellIndex;

	 				console.log('Zeilennummer: '+rownumber + ' Spalte:' +cellNumber);

	 				if(cellNumber==2) {
	 				console.log('increase');
	 				increase(rownumber);
	 				}

	 				if(cellNumber==3) {
	 				decrease(rownumber);
	 				}

	 				}

	 		 	function increase(rownumber) {
				rownumber++;
	 			var table = document.getElementById('shoppingTable');
				productID = table.rows[rownumber].cells[0].innerHTML;
	 			window.open('index.php?view=shoppingcart&action=mod&id2Change='+productID+'&change=up','_self')

	 			}

	 			function decrease(rownumber) {
				rownumber++;
	 			var table = document.getElementById('shoppingTable');
				productID = table.rows[rownumber].cells[0].innerHTML;

				window.open('index.php?view=shoppingcart&action=mod&id2Change='+productID+'&change=down','_self')
	 			return false;
	 			}



	 	</script>";

	 	return $table;

//
// 	 	var table = document.getElementById('shoppingTable');

// 	 	amount = table.rows[rownumber].cells[1].innerHTML;
// 	 	id = table.rows[rownumber].cells[0].innerHTML;

	 	//window.alert(this.innerHTML);
	 	//Wenn cellIndex = 2 liefert, will man erhöhen -> erhöhen
	 	//Wenn cellIndex = 3 liefert, will man reduzieren
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