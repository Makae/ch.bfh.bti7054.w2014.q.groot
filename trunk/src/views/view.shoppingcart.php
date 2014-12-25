<?php
  class GrootShoppingcartView implements IView {

    public function name() {
      return 'shoppingcart';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletNavi() {
      return array();
    }

    public function viewletFooter() {
      return null;
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    public function render() {
	
   $htmlcontent = "Your shopping cart is empty.";
   //$match = "no";
   
   //Check ob Anpassung mit + / - gemacht wurde
   if(isset($_GET['change'])) {
   	
   	$action = $_GET['change'];
   	
   	if($action == 'up')
   		$change = +1;
   	else 
   		$change = -1;
   	
   		$id2Change = $_GET['id2Change'];
   		$myArray = json_decode($_COOKIE["shoppingCart"]);
   		
   		foreach($myArray as $index) {

   			if($index->ID == $id2Change && $index->amount > 1) {
  
   				$index->amount = $index->amount+$change;
   				$myArray = array_values($myArray);
   				break;
   				}
   				
   			//Spezialfall wenn man von 1 +1 machen will
   			if($index->ID == $id2Change && $index->amount == 1 && $change == +1) {
   				
   					$index->amount = $index->amount+$change;
   					$myArray = array_values($myArray);
   					break;
   				}
   			}
   		
   			setcookie("shoppingCart", json_encode($myArray));
   			sleep(1); //musste ich machen, da das Script sonst vorgriff
   			$myCart = new ShoppingCart($myArray);
   			$htmlcontent = $myCart->displayCart();
   		}
 

    if(isset($_POST["clearCart"])) {
    		
    		setcookie("shoppingCart", false); //löscht das Cookie wenn man den Warenkorb leert
    	}
    	
    
    if(isset($_GET["remove"])) {
    	$myArray = json_decode($_COOKIE["shoppingCart"]);
		$i=0;
     	foreach($myArray as $index) {
    		
    		if($index->ID == $_GET["remove"]) {
    			unset($myArray[$i]);
				$myArray = array_values($myArray);
				break;
    		}
    	$i++;
    	}
    	setcookie("shoppingCart", json_encode($myArray));
		
    	if(sizeof($myArray)==0) {
    		//Keine Items mehr im Korb
    		setcookie("shoppingCart", false); //Cookie wird gelöscht
    	}
    	
    	sleep(1); //musste ich machen, da das Script sonst vorgriff
    	$myCart = new ShoppingCart($myArray);
    	$htmlcontent = $myCart->displayCart();
    }

     
    	if(!isset($_GET['change']) && !isset($_POST["clearCart"]) && isset($_COOKIE["shoppingCart"])&&!isset($_GET["remove"])) {
    		//Waiten weil die Bearbeitung des Cookies zu lange dauert
    		
    	$myArray = json_decode($_COOKIE["shoppingCart"]);
    	
    	//$htmlcontent = $htmlcontent. "Warenkorb:" .print_r(array_values($myArray));
       	
    	include_once ('classes/class.shoppingcart.php');
    	$myCart = new ShoppingCart($myArray);
    	$htmlcontent = $myCart->displayCart();
    	
    	}
    	
    	return $htmlcontent;
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>