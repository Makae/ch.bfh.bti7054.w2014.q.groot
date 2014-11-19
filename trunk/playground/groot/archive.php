<?php

/*
 // Tabelle erstellen
echo '<table id="productsTable" border="1" margin="10"> <tr bgcolor="yellow"><td> Titel <td>Jahr<td>Genre';

// Einträge in die Tabelle machen
for($i = 0; $i < count ( $books ["title"] ); $i ++) {
echo "<tr><td>{$books["title"][$i]}
<td>{$books["year"][$i]}
<td>{$books["genre"][$i]}";
}
// Tabelle schliessen
echo "</table>";
*/

$formfields = array (
		"firstname", "lastname", "streetname"
);

echo "<table>";
foreach($formfields as $value) {
	echo"<tr>";
	echo"<td>$value<td><input type='text'></input><br>";
}

echo "</table>";

?>

//Wurde durch openRequesteView() ersetzt:

// if(isset($_GET["view"])) {

// switch ($_GET["view"]) {

// case 'infoCall':
// 	include_once 'infoCall.php';
// 	break;
	
// case 'home':
// 	include_once ("home.php");
// 	break;
	
// case 'products':
// 	include_once ("products.php");
// 	break;
	
// case 'profile':
// 	include_once ("profile.php");
// 	break;

// case 'categories':
// 	include_once ("categories.php");
// 	break;
	
// case 'order':
// 	include_once 'order.php';
// 	break;		
	
// case 'confirmation':
// 	include_once 'confirmation.php';
// 	break;
		
// default:

// 	}
// }

// else require 'welcome.php';