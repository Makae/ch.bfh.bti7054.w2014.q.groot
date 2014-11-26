<html>
<head>
</head>
<link rel="stylesheet" href="styles.css" />
<body>

<?php
//session_start(); ist nicht nötig, weil die index.php die Session schon eröffnet hat

$cart = new ShoppingCart();
$cart = $_SESSION["cart"];

$cart->display();


echo "add Order";
$mysqli = new grootDB('localhost', 'root', '', 'grootDB');
$mysqli->addOrder(1, "by train", "cash", "lorem");

//Hier nun die Optionen angeben und nachdem man auf Buy geklickt hat, den Eintrag in der Order DB machen und Positionen dazu erstellen

echo "<h2>Shipping<br></h2>
<input type='radio' name='radio_list[]' value='Standard' checked='checked'>Standard</input><br>
<input type='radio' name='radio_list[]' value='By plane'>By plane</input><br>
<input type='radio' name='radio_list[]' value='By the Flash'>By the Flash</input>
<br><br>";

//Auch wenn sich Radiobuttons für single-select aufdrängen, ist es hier übungshalber trotzdem mit checkboxes gemacht
echo "<h2>Payment<br></h2>"; //Wenn man ohne JavaScript auf eine Box gehen will, muss man Radiobuttons nehmen
echo "<input type='radio' name='paymentBox[]' value='Creditcard'>Creditcard</input><br>";
echo "<input type='radio' name='paymentBox[]' value='Invoice'>Invoice</input><br>";
echo "<input type='radio' name='paymentBox[]' value='Monopoly Dollars'>Monopoly Dollars</input>";
echo "<br><br>";

echo '<textarea name="comments" rows=5 cols=80 placeholder="Insert your comment here..."></textarea>';

echo "<br><br>";
echo "If you have completed the necessary informations click on the  \"Confirm-\"Button in order to proceed to the checkout.<br><br>";
echo "<input type='submit' onclick='return nextValidation()' value='FINISH ORDER'></input>";
echo " Durch klicken auf diesen Button wird die Bestellung ausgelöst.";


?>