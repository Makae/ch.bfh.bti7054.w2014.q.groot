<?php
//session_start(); //unn�tig, da schon in index.php gestartet
?>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="cookieHandler.js"></script>

</head>
<body>

<!-- 15.11.2014: Beschrieb addToCard.php:
Wenn ein Product mit addToCard zum Warenkorb hinzugef�gt wird wird dieses Script aufgerufen.
�bergeben wird per POST die ID des Produktes.

***ERSTEINKAUF***
-Das gekaufte Produkt wird ins Session Cookie gelegt in das Array "chosenProducts"
Falls es der erste Aufruf / Warenkorbeintrag ist, so ist dieses Array im Sessioncookie noch nicht vorhanden
und das Array $selectedProducts wird angelegt.


dud -->
<?php

if(isset($_POST['clean'])) {
	echo $_POST['clean'];
	if($_POST['clean']) {
		echo "SessionCookie gel�scht";
		echo "<br><button onClick=\"self.location='index.php?view=products'\">Back to products</button><br><br>";
		$_SESSION["chosenProducts"] = array();
		return false;	
	}
}

$tempArray = array();


echo "<div class='cardDiv'>";


if(isset($_POST["productID"])) {
	$chosenProduct = $_POST["productID"]; //Was von der Product Seite daherkam, also ausgew�hlt wurde.
	echo "Produkt Nr.: $chosenProduct wurde ausgew�hlt";
}

if(!isset($_SESSION["chosenProducts"]) && isset($_POST["productID"])) {
	$selectedProducts = array($_POST["productID"]);
	$_SESSION["chosenProducts"] = $selectedProducts;
	
	//$tempArray = array();
	//$tempArray = $_SESSION["chosenProducts"];
} //Beim ersten Kauf wird das Produkt so eingef�gt


//Sonst, wenn es schon gesetzt ist, also man zum zweiten Mal kommt f�gt man das ausgew�hlte Produkt der SessionVariable chostenProducts hinzu
else {
global $tempArray;
$tempArray = $_SESSION["chosenProducts"];
$tempArray[] = $chosenProduct;
$_SESSION["chosenProducts"] = $tempArray;
}

// if(sizeof($tempArray)>0) {


	echo "<br><h2>Nun im Warenkorb:</h2>
		<br>";
	
	foreach ($tempArray as $value) 
		echo "Buch Nummer: $value<br>";
	
//echo var_dump($tempArray);
//Durch Array gehen und Eintr�ge auflisten:



//Danach �ber einen zur�ck Button wieder auf die Produktliste. Dort diese Produkte tagen, die ich bereits gekauft habe (einf�rben und ausgrauen)



//echo "<form action=><input type='submit' value='Warenkorb leeren' name'clearSC'></input></form>"; //Damit SessionCookie Variable l�schen

echo "<br><button onclick='history.go(-1);'>Back </button><br><br>";

echo "</div>"; //ENDE DES CARD DIVS



$lan = getCurrentLanguage();

echo "<form action='index.php?view=addToCart&lan=$lan' method='post'>";
echo "<input type='submit' value='Delete ShoppingCard'></input><br><br>";
echo "<input type='hidden' name='clean' value='true'></input>";
echo "</form>";
//Das kann ich nicht mit JavaScript machen, da ich die SessionCookie Variablen ja nicht vom Client aus modden kann
//echo "<input type='button' onClick='clearSC()' value='Warenkorb l�schen'></input>"; 

function clearSC() {
echo "Clear SC has been Called";
}

?>

</body>
</html>