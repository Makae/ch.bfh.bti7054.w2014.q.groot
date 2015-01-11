<?php
/*
 * Klasse für den Warenkorb
 * Autor: F.Schwab
 * Eine Instanz dieser Klasse wird erzeugt um den Warenkorb anzeigen zu lassen.
 * Als Argumente für den Konstruktor kommt ein Array mit den bereits gesammelten Items mit.
 */

class ShoppingCart {

	const classInfo = "shoppingCart";
	private $items = array ();
	private $totalPrice = 0;
	private $userID = "";
	private $subTotal = 0;

	function __construct($carArray) {
		$this->items = $carArray;
	}

	public function getUserID() {
		return $this->userID;
	}

	public function setUserID($userID) {
		$this->userID = $userID;
	}

	public function emptyCart() {
		$this->items = array ();
	}

	public function removeItemCompletely($ID) {
		unset ( $this->items [$ID] );
	}

	public function removeItem($ID, $quant) {
		if ($this->items [$ID] == 0 || $this->items [$ID] < $quant)
			return false;
		else {
			$this->items [$ID] -= $quant;
			if ($this->items [$ID] == 0)
				unset ( $this->items [$ID] ); // Unsetten, damit es dann im Warenkorb nicht als Artikel erscheint mit Quantity '0'
			return true;
		}
	}

	public function calculatePrice() {
		return $this->subTotal;
	}

	public function getCart() {
		$cart = array();
		foreach ( $this->items as $index ) {
			$cart[$index->ID] = $index->amount;
		}
		return $cart;
	}

	public function displayCart() {
		$TID = 0;

		if (sizeof ( $this->items ) == 0)
			return i("Your shopping cart is empty.");

		$table = ""; //Erstellen des HTML Contents, der von der displayCart() Funktion dann zurückgegeben wird

		$table = "<p>".i('Your shoppingcart contains').": " . sizeof ( $this->items ) . " ".i('product(s)')."</p>" . "<table id='shoppingTable'>" . "<tr id='tableTopics'>
		<td>".i('isbn')."</td>
		<td>".i('Amount')."</td>
		<td>".i('Title')."</td>
		<td></td>
		<td></td>
		<td>".i('Price')."</td>
		<td></td>";

		/* Die Tabelle zur Anzeige der in den Korb gelegten Items wird aufbereitet. Der Remove Button wird hinter jeden Zeileneintrag mit der entsprechenden Post Variable
		 * gesetzt und die + und - Buttons werden angehängt
		 * Update 30.12: Anstatt meiner Lösung unten hätte ich besser die +/- Buttons auch schon bei der Generierung mit den Actions belegen sollen.
		 */
		foreach ( $this->items as $index ) {
			$ID2del = $index->ID;
			$list = BookModel::findList(array('isbn' => array($index->ID)), null);
			$title = $list[0]['title'];
			$price = $list[0]['price'];
			$totPrice = $price * $index->amount;

			$table = $table . "<tr id=$TID onclick=''><td>$index->ID</td>
			<td>$title</td>
			<td name='amount'>$index->amount</td>
	 	 	<td>
	 	 	<input type='button' id='plusButton' value='+'></input></td>
	 	 	<td><input type='button' id='minusButton' value='-'></input></td>
	 	 	<td>$totPrice</td>
	 	 	<td><form action='" . Controller::instance ()->getViewUrl ( 'shoppingcart' ) . "&remove=$ID2del' method='post'><input type='submit' value='Remove'></input></form></td>
	 	 	</tr>";

			$TID ++;
			$this->subTotal+=$totPrice;
		}



		/*
		 * Totaler Wert des Warenkorbs
		 */

		$table = $table . "
				<tr>
		<td></td><td></td><td></td><td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		<td></td><td></td><td></td><td></td>
		<td>Sub Total:</td>
		<td>$this->subTotal</td>
		<td></td>
		</tr>";

		/*
		 *
		 */
		$table = $table . "</table>
	 			<div class='action-wrapper'><form action='index.php?view=shoppingcart' method='post' class='clear-form'>
	 			<input type='submit' value='".i('Empty cart')."' class='button button-primary'></input>
	 			<input type='hidden' name='clearCart'></input></form>";
	 	//Add Button go to payment

			$table = $table . "
				<a href='index.php?view=payment' class='next'>
                  <input class='button button-primary' type='button' value='".i('Go to payment')."'></input>
                </a></div>
			";

		// Hier den JavascriptCode rein: Erhöhen liest Anzahl aus, zählt eins dazu und reloaded the page mit dem GET Paramter: &update=ID&Amount=NEUER AMOUNT
		$table = $table . "
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

	 				if(cellNumber==3) {
	 				console.log('increase');
	 				increase(rownumber);
	 				}

	 				if(cellNumber==4) {
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
	}

}

?>