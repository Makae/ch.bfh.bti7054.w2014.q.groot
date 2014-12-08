<?php
//session_start(); //unn�tig, da schon in index.php gestartet
?>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="cookieHandler.js"></script>
</head>
<body>

<!--  if(isset($_POST['clean'])) { 
 	echo $_POST['clean'];
 	if($_POST['clean']) {
		echo "SessionCookie gel�scht";
echo "<br><button onClick=\"self.location='index.php?view=products'\">Back to products</button><br><br>";
 		$_SESSION["chosenProducts"] = array();
 		return false;	
 	}
  }   -->
  

<?php
$lan = $_COOKIE["language"];

// if(isset($_COOKIE["ShoppingCart"])) {
	
// 	$shoppingCart = unserialize($_COOKIE["ShoppingCart"]);
// 	echo "Deserialisiert! Ihr ShoppingCart vom letzten Besuch:";
// 	$_SESSION["cart"] = $shoppingCart;
// 	$_SESSION["cart"]->display();
// }

//Wenn noch nichts im Warenkorb ist, wird ein neuer Warenkorb erstellt + das Cookie auf dem Client angelegt mit dem Inhalt des Warenkorbs
if(!isset($_SESSION["cart"])) {
	$_SESSION["cart"] = new ShoppingCart;
	setcookie("ShoppingCart", serialize($_SESSION["cart"]), time()+3000);
	
}

if(isset($_POST["delete"])) {
	echo "Produkt:". $_POST['delete']. " gel�scht<br>";
	$_SESSION["cart"]->removeItemCompletely($_POST["delete"]);
}

else if (isset($_POST["cleanCart"])) {
	echo "Warenkorb wurden gel�scht!<br>";
	$_SESSION["cart"]->emptyCart();
}

//Wenn schon ein Warenkorb existiert, wird das Produkt, welches �ber die POST Variable "productID" kam zum Cart hinzugef�gt
else { 
	echo "Neues Produkt hinzugef�gt:<br>";
	echo $_SESSION["cart"]->addItem($_POST["productID"], $_POST["price"], $_POST["quantity"]); 
	
	setcookie("ShoppingCart", serialize($_SESSION["cart"]), time()+3000);
	echo "<br>gespeichert in lokalem cookie. Ausgabe des Lokalen Cookies:<br>";
	unserialize($_COOKIE["ShoppingCart"])->display();
}




echo $_SESSION["cart"]->display();

echo "<div class='cardDiv'>";
echo "<br><button onclick='history.go(-1);'>Back </button><br>";
echo "<br><form action='index.php?view=addToCart&lan=$lan' method='post'><input type='submit' value='EmptyCart'></input><input type='hidden' name='cleanCart' value='true'></input></form>";
//Checkout
echo "<br><form action='index.php?view=checkOut&lan=$lan' method='post'>
<input type='submit' value='Check-Out'></input>
<input type='hidden' name=' ' value=' '></input>
</form>";

echo "</div>"; //ENDE DES CARD DIVS

$lan = getCurrentLanguage();



?>

</body>
</html>