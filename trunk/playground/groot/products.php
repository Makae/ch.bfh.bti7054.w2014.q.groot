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

/*Implementation mit Datenbankanbindung*/

$mysqli = new grootDB('localhost', 'root', '', 'grootDB');


$bookResult = $mysqli->getAllBooks();

$result = $mysqli->query("SELECT * FROM book"); //Returns a mysqli_result-Objekt, also eine Instanz der mysqli_result Class / ein Ergebnisobjekt zurück

if($result->num_rows > 0)
	echo "Anzahl Bücher im Store: ". $result->num_rows . "<br><br>";


for ($j=0; $j < $bookResult->num_rows; $j++) {
	$book = $bookResult->fetch_object();
	
	echo "<div class='productDiv'>"; //Für jedes Produkt ein Div
	
	//PIC
	echo "<div class='picDiv'>";
	echo "<img src='piclogo.jpg' class='productPic'>";
	echo "</div>";
	
	
	//Beschreibung
	echo '<div class="productDescription">';
	echo "<b>".$book->title."</b><br>";
	echo $book->description."</div>";

	//Preis
	echo "<div id='productprice'>";
	echo "Price: ".$book->price ."</div>";
	
	//Option (Ebook oder nicht)
	echo "<div id='optionDiv'><select name='option'>";
	echo "<option value='ebook'>E-Book</option>";
	echo "<option value='paperback'>PaperBack</option></select>	</div>";
	
	//Buy button
	echo "<div class='buttonDiv'>";
	echo "<form action='index.php?view=addToCart&lan=$lan' method='post'>";
		echo "Anzahl: <input type='text' name='quantity' size='3'></input>";
		echo "<input type='hidden' name='productID' value=$book->id> </input>";
		echo "<input type='hidden' name='price' value=$book->price> </input>";
		echo "<input type='submit' value='Add to Card' width='48' height='48 name='addButton'</input></form></div>";

	echo "(ID: $book->id)";


}

/*
 * 
 * Alte Idee mit bereits gekauften Dingen
 * 
 * 		
		
			
		
		foreach($IDArray as $ID) {
				if ($ID == $j) $bought = true;	}
				
		if($bought)
			echo "<input type='submit' value='already in Card' width='48' height='48 name='addButton' disabled='disabled'</input>";
 * 
 */


$bla   = $mysqli -> query('INSERT INTO bla ...)');
$blubb = $mysqli -> query('INSERT INTO blubb ...)');
if ($bla && $blubb) {
	$mysqli -> commit();
}

/*
 * LÖSUNG OHNE DB
 */
echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
$IDArray = array();
for ($j=1; $j < 8; $j++) {
	$bought = false;
	//Pro Durchgang ein Div

	
}	
	




?>

</HTML>
