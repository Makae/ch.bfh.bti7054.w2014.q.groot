<html>
<head>
</head>
<link rel="stylesheet" href="styles.css" />
<body>

<?php
//session_start(); ist nicht n�tig, weil die index.php die Session schon er�ffnet hat
$lan = getCurrentLanguage();
$cart = new ShoppingCart();
$cart = $_SESSION["cart"];

$cart->display();


$mysqli = new grootDB('localhost', 'root', '', 'grootDB');
$_SESSION["db"] = $mysqli;

//Dieses Form �bergibt die notwendigen Informationen �ber Post. Die Informationen aus dem ShoppingCart bleiben im Cart Objekt in der SessionVariable und werden
//im n�chsten Screen, dem "confirmation"-Screen wo auch die Order/Position Objekte gebaut werden ausgelesen

echo "<form action='index.php?view=confirmation&lan=$lan' method='post'>";

echo "<h2>Shipping<br></h2>
<input type='radio' name='radio_list[]' value='Standard' checked='checked'>Standard</input><br>
<input type='radio' name='radio_list[]' value='By plane'>By plane</input><br>
<input type='radio' name='radio_list[]' value='By the Flash'>By the Flash</input>
<br><br>";

//Auch wenn sich Radiobuttons f�r single-select aufdr�ngen, ist es hier �bungshalber trotzdem mit checkboxes gemacht
echo "<h2>Payment<br></h2>"; //Wenn man ohne JavaScript auf eine Box gehen will, muss man Radiobuttons nehmen
echo "<input type='radio' name='paymentBox[]' value='Creditcard'>Creditcard</input><br>";
echo "<input type='radio' name='paymentBox[]' value='Invoice'>Invoice</input><br>";
echo "<input type='radio' name='paymentBox[]' value='Monopoly Dollars'>Monopoly Dollars</input>";
echo "<br><br>";

echo '<textarea name="comments" rows=5 cols=80 placeholder="Insert your comment here..."></textarea>';

echo "<br><br>";
echo "If you have completed the necessary informations click on the  \"Confirm-\"Button in order to proceed to the checkout.<br><br>";

//Form mit action, welches die Confirmation Site anzeigt, die auch die n�tigen Scripts ausf�hrt

echo "<input type='submit' value='FINISH ORDER'></input>";
echo "Durch klicken auf diesen Button wird die Bestellung ausgel�st.</form>";

//Beim Klick auf Finish Order, wird
//1. Eine Order erstellt und danach werden die einzelnen Positionen erstellt und mit dem Fremdschl�ssel auf die OrderID
//Dazu w




?>