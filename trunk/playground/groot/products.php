<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<link rel="stylesheet" href="styles.css" />
</head>

<?php


include_once ('dictionary.php');

$lan = getCurrentLanguage();

echo "<p id = 'contentTitle'>".translate("product", $lan)."</p>";

/*Implementation mit Datenbankanbindung*/

$mysqli = new grootDB();
$bookResult = $mysqli->getAllBooks();

if(isset($_GET["cmd"])) {
	$command = $_GET["cmd"];

	if($command=='ins') {
		$mysqli->addBook($_POST["Title"], $_POST["Genre"], $_POST["ISBN"], $_POST["Year"], $_POST["Price"], $_POST["Author"], $_POST["Pages"], $_POST["Description"]);
		$mysqli->commit();
	}
	else if($command=='del') {
		echo $_POST["titleToDel"];
		$mysqli->deleteBook($_POST["titleToDel"]);
	}

	echo "
	<script type='text/javascript'>
	console.log('$lan');
	</script>";
}


if($bookResult->num_rows > 0)
	echo "Anzahl Bücher im Store: ". $bookResult->num_rows . "<br><br>";


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

	echo "(ID: $book->id)</div>"; //+/div is the end of the product div


}

/*
Alte Idee mit bereits gekauften Dingen

	foreach($IDArray as $ID) {
		if ($ID == $j) $bought = true;	}
				
		if($bought)
			echo "<input type='submit' value='already in Card' width='48' height='48 name='addButton' disabled='disabled'</input>";
 */
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


echo "<div class='bookAdministration'><br><h2>Buch-Administration</h2>";

//Aufbereiten der Genreliste zur Auswahl
$genres = $mysqli->getGenres();
$genreArray = array();

while($genreObject = $genres->fetch_object()) { //Solange da noch ein Objekt kommt
	$genreArray[$genreObject->id] = $genreObject->name;
}

echo "<table><tr>
		<td>Title</td>
		<td>Genre</td>
		<td>ISBN</td>
		<td>Year</td>
		<td>Price</td>
		<td>Author</td>
		<td>Pages</td>
		<td>Description</td></tr>";

echo "<tr>";//Am Anfang der Zeile mit den Inputfields muss der form-Action Command kommen
echo "<form action=$actual_link&cmd=ins method='post'>";
echo "<td><input name='Title' id='titleField' value='enter a title'/>
		
		<td><select name='Genre' id='genreField'>";
		foreach($genreArray as $index => $value) {
		echo "<option>$value</option>";
		}			
		echo "</select></td>		
		<td><input name='ISBN'/>	
		<td><input name='Year' id='yearField'/>	
		<td><input name='Price'/>
		<td><input name='Author'/>	
		<td><input name='Pages'/>
		<td><input name='Description'/>
		<td><input type='submit' value='Add Book'/>
		</tr></table>";

//Als Übung: Mit Javascript eingebettet in PHP default Werte setzen
$date = date("m.d.Y"); 
$value = 2014;

echo "<script type='text/javascript'>
document.getElementById('titleField').setAttribute('value', 'Pflichtfeld');
				document.getElementById('yearField').setAttribute('value', $value);	

</script>";
		
		
		
//neue Table mit Auflistung der Bücher oben schon gemacht, aber hier noch um sie auch updaten zu können.
$titleArray = $mysqli->getTitles();
		
echo "<br><br><table border='1'><tr>
				<td><h2>Delete Titles: </h2></td></tr>";
	//Für jeden Eintrag in der Buchtabelle nun eine Zeile
	for($i=0; $i < sizeof($titleArray); $i++) {
		echo "<tr><td>$titleArray[$i]</td>";
		echo "<td><form action='$actual_link&cmd=del' method='post'>
				<input type=submit value='Delete'></input></tr>
				<input type='hidden' name='titleToDel' value='$titleArray[$i]'></input></form>";
	}		
echo "</table>";				
		
		
echo "</div>"; //Ende des Divs für die BookAdministration


























/*
 * LÖSUNG OHNE DB
 */
$IDArray = array();
for ($j=1; $j < 8; $j++) {
	$bought = false;
	//Pro Durchgang ein Div

	
}	
	

?>

</HTML>
