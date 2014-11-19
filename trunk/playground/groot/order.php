<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="functions.js"></script>
</head>

<body>
<?php
session_start(); //Um noch zu �bergeben, was von Seite 1 �brigblieb

include_once ('dictionary.php');
include_once 'utility.php';

$lan = getCurrentLanguage();
echo "<p id = 'contentTitle'>".translate("confirmation", $lan)."</p>";

$deliveryMethod ="default";
$payMethod = "default";
$comment  = ($_POST['comments']);
$shape = $_POST['shape']; //da es auf jeden Fall nicht leer ist, ist das okay


if(!empty($_POST['radio_list'])) { //Das heisst, wenn eines selektiert wurde
    foreach($_POST['radio_list'] as $check) { //Das Array hat so viele Eintr�ge wie ausgew�hlte Optionen. Hier aber auf eines beschr�nkt
    	$deliveryMethod = $check;
    	}
    }
//Auslesen der Zahlungsmehtode
if(!empty($_POST['paymentBox'])) {
	foreach ($_POST['paymentBox'] as $payment) 
		$payMethod = $payment;
}

//Summary of chosen options
echo "<h2>Summary of your selections:</h2><br>";
echo "<table cell>";
echo "<tr>";
echo "<td>Chosen shape: <br></td>";
echo "<td>$shape</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Chosen delivery: <br></td>";
echo "<td>$deliveryMethod</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Chosen payment: <br></td>";
echo "<td>$payMethod</td>";
echo "</tr>";
echo "</table>";

echo "<br><textarea readonly rows=4 cols=80 >";
echo $comment;
echo "</textarea><br>";


/*
 * Vervollst�ndigen der Bestellung mit Angabe des vollen Namens, der Email, der Lieferadresse: Verwendung von Formelementen: SelectionList f�r Land, Textarea f�r Comment
 * 
 */

echo "<div class=contactInfos>"; //START DIV contactInfos
echo "<h2>Please complete the shipping details below:</h2>";

/*
 * START FORM: required tag ist einfach. Mache es aber zum �ben noch mit einem loop �ber alle input elemente vom typ text
 * required f�rs testing rausgenommen
 */


echo "<form action='index.php?view=confirmation&lan=$lan' id='personalForm' method='post'>";
echo "<table>";

echo "<tr><td>First Name: </td>";
echo "<td><input type='text' name='firstname' id='firstname' maxlength='20'></input></td><br>";

echo "<tr><td>Last Name: </td>";
echo "<td><input type='text' name='lastname'id='lastname' maxlength='20'></input></td><br>";

echo "<tr><td>Streetname: </td>";
echo "<td><input type='text' name='streetname' id='streetname' maxlength='20'></input></td><br>";

echo "<tr><td>Street #: </td>";
echo "<td><input type='text' name='streetnr' id='streetnr' maxlength='3'></input></td><br>";

echo "<tr><td>City: </td>";
echo "<td><input type='text' name='city' id='city'></input></td><br>";

echo "<tr><td>E-Mail: </td>";
echo "<br><td> <input type='text' id='email'></input></td><br>";


//Build Countryselectionlist with array
$countries = array ("ch"=>"Switzerland", "de"=>"Germany", "at"=>"Austria", "en"=>"England", "fin"=>"Finland");

echo "<tr><td>Country:</td><td><select name=\"country\" size=\"1\">";
foreach($countries as $value) {
	echo "<option value=$value>$value</option>";
}
echo "</select><br><br></td>";
echo "</table></div>";


//Aufgabe 6.4 Confirmation: Die Daten zu einer Confirmation Page schicken, die den Kunden �ber das bestellte Produkt, die Options und die Shipping Address informiert informiert
echo "<input type='button' onclick='checkEntries()' value='ORDER'></input>";

//Email senden an Kunden & an den ShopAdmin:



echo"</form>";

$_SESSION['infos'] = array ("delivery"=>$deliveryMethod, "payMethod"=>$payMethod, "shape"=>$shape, "comment"=>$comment);

?>
</body>

</html>