<?php
//session_start(); //unnötig, da schon in index.php gestartet
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
		echo "SessionCookie gelöscht";
echo "<br><button onClick=\"self.location='index.php?view=products'\">Back to products</button><br><br>";
 		$_SESSION["chosenProducts"] = array();
 		return false;	
 	}
  }   -->
  

<?php
$lan = $_COOKIE["language"];

//Wenn noch nichts im Warenkorb ist, wird ein neuer Warenkorb erstellt
if(!isset($_SESSION["cart"])) {
	$_SESSION["cart"] = new ShoppingCart;
}

if(isset($_POST["delete"])) {
	echo "Produkt:". $_POST['delete']. " gelöscht<br>";
	$_SESSION["cart"]->removeItemCompletely($_POST["delete"]);
}

else if (isset($_POST["cleanCart"])) {
	echo "Warenkorb wurden gelöscht!<br>";
	$_SESSION["cart"]->emptyCart();
}

//Wenn schon ein Warenkorb existiert, wird das Produkt, welches über die POST Variable "productID" kam zum Cart hinzugefügt
else { 
	echo "Neues Produkt hinzugefügt:<br>";
	echo $_SESSION["cart"]->addItem($_POST["productID"], $_POST["price"], $_POST["quantity"]); 
	//Noch den Preis hinzufügen - nun wohl besser mit Item arbeiten
	
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