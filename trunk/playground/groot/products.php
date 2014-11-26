<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="functions.js"></script>
</head>

</head>

<?php
//session_start(); //unnötig, da schon in index.php gestartet

include_once ('dictionary.php');

$lan = getCurrentLanguage();

echo "<p id = 'contentTitle'>".translate("product", $lan)."</p>";

$IDArray = array();

//Multidimensionales Array mit Produkten
$books = getBookArray();
	
for ($j=1; $j < 8; $j++) {
	$bought = false;
	//Pro Durchgang ein Div

	echo "<div class='productDiv'>";
	
		echo "<div class='picDiv'>";
		echo "<img src='piclogo.jpg' class='productPic'>";
		echo "</div>";
				
		echo 	'<div class="productDescription">';	
		echo 	"dvi ivni ndn sv isn dinds ivnsdi nvidsnv isdnvi sdnvi n dsinv vi ivni ndn sv isn dinds ivnsdi nvidsnv isdnvi sdnvi n dsinv </div>";
		
		echo "<div id='productprice'>";
		$price =  11;
		echo "<p>PRICE: $price SFr.";
		echo "</div>";
		
		$_SESSION["counter"] = 1;

		echo "<div class='buttonDiv'>";
		
		echo "<form action='index.php?view=addToCart&lan=$lan' method='post'>";		
		
		foreach($IDArray as $ID) {
				if ($ID == $j) $bought = true;	}
				
		if($bought)
			echo "<input type='submit' value='already in Card' width='48' height='48 name='addButton' disabled='disabled'</input>";
		else 
			echo "<input type='submit' value='Add to Card' width='48' height='48 name='addButton'</input>";
		
		echo "Anzahl: <input type='text' name='quantity' size='3'></input>";
		echo "<input type='hidden' name='productID' value=$j> </input>";
		echo "<input type='hidden' name='price' value=$price> </input>";
		echo "(ID: $j)";
		echo "</form></div>"; //Ende Div für Button

	echo "</div><br>";
	
}	
	
echo "</p";

function addToCard() {
echo "ADDED";
}



function getBookArray() {

	return array (

			"title" => array ("Titel1", "Titel2", "Titel3"),
			"year" => array ("2000", "1999", "2013"),
			"genre" => array ("Krimi", "Comic", "Roman")
	);
}

?>

</HTML>
