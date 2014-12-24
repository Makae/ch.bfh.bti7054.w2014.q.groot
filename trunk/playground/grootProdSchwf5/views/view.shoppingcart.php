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

    	if(isset($_POST["clearCart"])) {
    		
    		setcookie("shoppingCart", "");
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
    }	
    	
     $htmlcontent = "Der Warenkorb enthält keine Produkte";
     
    	if(isset($_COOKIE["shoppingCart"])) {
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