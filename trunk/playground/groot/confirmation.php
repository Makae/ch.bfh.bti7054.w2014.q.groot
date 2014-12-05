<html>
<head>
<link rel="stylesheet" href="styles.css" />

<script type="text/javascript">
function alerting() {
	window.alert("TEST");
}
</script>
</head>
<body>


<!-- INFO ZUM BESTELLVORGANG: Besser w�re es gewesen, bei jedem Username/Password Login immer die gleiche Seite aufzurufen, damit man das zentral regelt und dort dann -->
<!-- die mysqli Connections als sessioncookie ablegt. So h�tte es vielleicht funktioniert,  aber das ist jetzt zu sp�t. -->
<!-- Ausserdem musste ich mit dem addOrder() etwas vereinfachen, weil ich die Profile auf die accounts tabelle und nicht auf die bestehenden usertabelle verlinkt habe. -->
<!-- jetzt wird jede Bestellung mit UserID 1 gemacht. -->
<!-- Aber mit den Bestellungen mache ich nicht mehr viel. M�sste man neu �berarbeiten. -->



Ihre Bestellung wurde aufgenommen und wird von uns bearbeitet.

<?php


$mysqli = new grootDB();
$loggedIn = false;
$userArray = array();
if(!isset($_SESSION["userInfo"])) {

	echo "Please LogIn - or create your Profile in the Profile section.<br>";
	echo "<form action='index.php?view=confirmation&lan=de' method='post'><br>User: <input name='user'/>";
	echo "Password: <input name='pw'/><input type='submit' value='LogIn'/></form>";
	exit("Bitte zuerst anmelden");
}
else {
	$userArray = $_SESSION["userInfo"];
}
	
if(isset($_POST["user"])) {
	if($mysqli->checkCredentials($_POST["user"], $_POST["pw"])) {
			$loggedIn = true;
			$_SESSION["userInfo"] = array("username"=>$_POST["user"]);
			$userArray = $_SESSION["userInfo"];
		}
		else {
			echo "LOGIN NOK - try again";
			
		}
}

if($loggedIn || isset($_SESSION["userInfo"])) {
	
	$cart = $_SESSION["cart"];
	$cart->setUserID($userArray["username"]);
	$mysqli->addOrder($userArray["username"], 'byTrain', 'cash', 'huhu');
	
}



//Bauen der einzelnen Positionen:



include_once 'dictionary.php';
include_once 'utility.php';
$lan = getCurrentLanguage();

echo "<p id = 'contentTitle'>".translate("confirmationMessage", $lan)."</p>";

echo "<div class='subjects'>";
echo "Ausgew�hlte Form: <br>";
echo "Ausgew�hlte Zahlungsart: <br>";
echo "Ausgew�hlte Versandart:<br>";


echo "Ihr Kommentar:<br><br>";

echo "</div>";

echo "<div class='values'>";


echo "</div>";

echo "<div class='pageContent'>";
echo "<br><p>Ihre Bestellung wird nun verarbeitet und sie erhalten ein Mail mit einem Link um den Status zu �berwachen.</p>";
echo "</div>"; //End of pageContent


?>


</body>

</html>
