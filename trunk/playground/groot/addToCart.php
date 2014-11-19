<?php
//session_start(); //unnötig, da schon in index.php gestartet
?>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="cookieHandler.js"></script>
</head>
<body>


<?php

// if(isset($_POST['clean'])) {
// 	echo $_POST['clean'];
// 	if($_POST['clean']) {
// 		echo "SessionCookie gelöscht";
// 		echo "<br><button onClick=\"self.location='index.php?view=products'\">Back to products</button><br><br>";
// 		$_SESSION["chosenProducts"] = array();
// 		return false;	
// 	}
// }

/*
 * *******************************************************************************************************************************
 */



if(!isset($_SESSION["cart"]))
	$_SESSION["cart"] = new ShoppingCart;

if(isset($_POST["delete"])) {
	echo "Produkt:". $_POST['delete']. " gelöscht<br>";
	$_SESSION["cart"]->removeItemCompletely($_POST["delete"]);
}

else { 
	echo "Neues Produkt hinzugefügt:<br>";
	echo $_SESSION["cart"]->addItem($_POST["productID"], $_POST["quantity"]); 
}
//echo "Produktnummer: ".$_POST["productID"]."und Anzahl".$_POST["quantity"];
//Prüfung auf akzeptierte Werte noch zu machen -> Warte auf Regex


echo $_SESSION["cart"]->display();



echo "<div class='cardDiv'>";



echo "<br><button onclick='history.go(-1);'>Back </button><br><br>";
echo "</div>"; //ENDE DES CARD DIVS

$lan = getCurrentLanguage();

// echo "<form action='index.php?view=addToCart&lan=$lan' method='post'>";
// echo "<input type='submit' value='Delete ShoppingCard'></input><br><br>";
// echo "<input type='hidden' name='clean' value='true'></input>";
// echo "</form>";


?>

</body>
</html>