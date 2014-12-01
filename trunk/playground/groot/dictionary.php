<?php

$testArray = array ("first"=>"Fabian", "second" => "Schwab");
$testArray2 = array (

		"A" => array ("first"=>"Fabian", "second" => "Schwab"),
		"V" => array ("first"=>"Fabian", "second" => "Schwab"),
);

function getArrayValue($ind) {
	global $testArray;
	if(isset($testArray2["A"][$ind])) 
		return $testArray2["A"][$ind];
	else return "";
	
}

function translate($key, $targetLan) {
	
	$langTable = array (

		"en" => array (
				"home" => "Home",
				"products" => "Products",
				"profile" => "Profile",
				"categories" => "Categories",
				"shopping card" => "Shopping Card",
				
				"welcome"=> "Welcome to the Groot Store!",
				"product" => "Welcome to the product section! Our productlist contains:",
				"profileText" => "That's your profile!",
				"homeText" => "Home",
				"categorieTitle" => "Our categories are:",
				"confirmation" => "Confirmation & Checkout",
				"confirmationMessage" => "Your order has been confirmed",
				"navigationList" => "Navigationlist"
		),
			

		"de" => array (
				"home" => "Startseite",
				"products" => "Produkte",
				"profile" => "Profil",
				"categories" => "Kategorien",
				"shopping card" => "Warenkorb",
				
				"welcome"=> "Willkommen im Groot Shop!",
				"profileText" => "Ihr Profil:",
				"product" => "Willkommen im Produktebereich! Unsere Produkteliste umfasst:",
				"homeText" => "Startseite",
				"categorieTitle" =>"Unsere Kategorien umfassen:",
				"confirmation" => "Bestätigung & Abschluss der Bestellung",
				"confirmationMessage" => "Ihre Bestellung wurde angenommen",
				
				"navigationList" => "Navigationsliste")
	);
	
	return $langTable[$targetLan][$key];
	
}
?>

