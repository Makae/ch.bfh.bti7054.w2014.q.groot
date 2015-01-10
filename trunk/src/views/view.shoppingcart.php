<?php

/*
 * Warenkorbansicht:
 * Autor: F.Schwab
 * Die Produkte, die man in den Warenkorb legt, werden in einem Array abgelegt, mit
 * dem man auch eine Instanz der ShoppingCart Klasse erstellt.
 * Zwischengespeichert werden gesammelte Produkte in einem Cookie, welches das JSON codierte 
 * Array enthält.
 */
class GrootShoppingcartView implements IView {
	public function name() {
		return 'shoppingcart';
	}
	
	public function viewletMainMenu() {
		return null;
	}
	
	public function viewletNavi() {
		return array ();
	}
	
	public function viewletFooter() {
		return null;
	}
	
	public function process() {
		// Here comes the processing of the field-parameters
	}
	
	public function render() {
		$htmlcontent = "Your shopping cart is empty.";

		/*Anzahl eines Artikels in der Warenkorbansicht will verändert werden. Dann wird die View neu mit dem entsprechenden Action
		Parameter up/down geladen*/
		if (isset ( $_GET ['change'] )) {
			$action = $_GET ['change'];
			if ($action == 'up')
				$change = + 1;
			else
				$change = - 1;
			
			$id2Change = $_GET ['id2Change'];
			$myArray = json_decode ( $_COOKIE ["shoppingCart"] );
			
			foreach ( $myArray as $index ) {
				
				if ($index->ID == $id2Change && $index->amount > 1) {
					$index->amount = $index->amount + $change;
					$myArray = array_values ( $myArray );
					break;
				}
				
				// Spezialfall wenn man von 1 +1 machen will
				if ($index->ID == $id2Change && $index->amount == 1 && $change == + 1) {
					$index->amount = $index->amount + $change;
					$myArray = array_values ( $myArray );
					break;
				}
			}
			
			/*Nachdem das Array mit den Auswahlen an Büchern durch +/- verändert wurde,
			wird das aktualisierte array wieder encoded als Cookie "shoppingCart" abgelegt*/
			setcookie ( "shoppingCart", json_encode ( $myArray ) );
			sleep ( 1 ); // musste ich machen, da das Script sonst vorgriff
			
			/*Nun wird der Warenkorb wieder angezeigt, in dem eine Instanz der ShoppingCart Class mit dem Array der Auswahlen gebaut wird
			und die displayCart Methode darauf angewendet wird.	*/
			$myCart = new ShoppingCart ( $myArray );
			$htmlcontent = $myCart->displayCart ();
		}
		
		if (isset ( $_POST ["clearCart"] )) {
			setcookie ( "shoppingCart", false ); // löscht das Cookie wenn man den Warenkorb leeren will
		}
		
		/*Entfernen einer Auswahl aus dem Korb:	URL wird mit dem remove parameter und dem ID Wert neu geladen.
		Das Array wird nach der ID durchsucht und der Arrayplatz an dieser Stelle "unsettet"
		*/
		if (isset ( $_GET ["remove"] )) {
			$myArray = json_decode ( $_COOKIE ["shoppingCart"] );
			$i = 0;
			foreach ( $myArray as $index ) {
				if ($index->ID == $_GET ["remove"]) {
					unset ( $myArray [$i] );
					$myArray = array_values ( $myArray );
					break;
				}
				$i ++;
			}
			setcookie ( "shoppingCart", json_encode ( $myArray ) );
			
			if (sizeof ( $myArray ) == 0) {
				// Keine Items mehr im Korb
				setcookie ( "shoppingCart", false ); // Cookie wird gelöscht
			}
			
			sleep ( 1 ); // musste ich machen, da das Script sonst vorgriff
			$myCart = new ShoppingCart ( $myArray );
			$htmlcontent = $myCart->displayCart ();
		}
		
		if (! isset ( $_GET ['change'] ) && ! isset ( $_POST ["clearCart"] ) && isset ( $_COOKIE ["shoppingCart"] ) && ! isset ( $_GET ["remove"] )) {
			$myArray = json_decode ( $_COOKIE ["shoppingCart"] );
			include_once ('classes/class.shoppingcart.php');
			$myCart = new ShoppingCart ( $myArray );
			$htmlcontent = $myCart->displayCart ();
		}
		
		$htmlcontent = '<h1>' . i ( 'Shoppingcart' ) . '</h1>' . $htmlcontent;
		return $htmlcontent;
	}
	
	public function ajaxCall() {
		// we will return the value as json encoded content
		return json_encode ( 'asdf' );
	}
}
?>