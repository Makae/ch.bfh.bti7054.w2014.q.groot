<?php
//session_start(); //unnötig, da schon in index.php gestartet

?>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php

//GetLanguage from Cookie:

$lan = $_COOKIE["language"];

if(isset($_POST["clean"]) && $_POST["clean"]=='true') {
	unset($_SESSION["cart"]);
	$_POST["clean"]=='false';
	echo "Warenkorb gelöscht.";
		//Arraylänge: ".sizeof($_SESSION["chosenProducts"]);
}

echo "<p id = 'contentTitle'>".translate("shopping card", $lan)."</p>";

if(isset($_SESSION["cart"])) {
	echo "<b><br>Ihr Warenkorb enthält folgende Produkte:</br></b>";
	$_SESSION["cart"]->display();
	
}

else
echo "<b><br>Ihr Warenkorb enthält noch keine Produkte.</br></b>";

echo "<br><form action='index.php?view=shopping%20card&lan=$lan' method='post'>";
echo "<input type='submit' value='Delete ShoppingCard'></input><br><br>";
echo "<input type='hidden' name='clean' value='true'></input>";
echo "</form>";

//Checkout
//Checkout
echo "<br><form action='index.php?view=checkOut&lan=$lan' method='post'>
<input type='submit' value='Check-Out'></input>
<input type='hidden' name=' ' value=' '></input>
</form>";

?>
</body>
</html>

<!-- 
Archiv:
$productArray = array();
if(isset($_SESSION["chosenProducts"]))
	$productArray = $_SESSION["chosenProducts"];
	
	if(sizeof($productArray)==0)
	echo "<br><br><br> Keine Produkte im Körbchen.<br><br><br>";

foreach ($productArray as $value)
	echo "<br><br><br>Produkt mit Bestell-ID: ".$value."<br><br>"; -->

	