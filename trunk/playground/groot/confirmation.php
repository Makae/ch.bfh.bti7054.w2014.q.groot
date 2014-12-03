<html>
<head>
<link rel="stylesheet" href="styles.css" />

<script type="text/javascript">
function alerting() {
	window.alert("TEST");
}
</script>

<!-- session_start(); nicht nötig, da index.php die session bereits startet-->

</head>
<body>

Ihre Bestellung wurde aufgenommen und wird von uns bearbeitet.

<?php
//Das Cartobjekt das mitkam
$cart = $_SESSION["cart"];
$mysqli = $_SESSION["db"];
$cart->getUserID();

//Damit ein Order generieren, worauf man dann mit den Positionen referenziert: addOrder($userid, $shipping, $payment, $notes)
$mysqli->addOrder();



//Bauen der einzelnen Positionen:



include_once 'dictionary.php';
include_once 'utility.php';
$lan = getCurrentLanguage();

echo "<p id = 'contentTitle'>".translate("confirmationMessage", $lan)."</p>";

echo "<div class='subjects'>";
echo "Ausgewählte Form: <br>";
echo "Ausgewählte Zahlungsart: <br>";
echo "Ausgewählte Versandart:<br>";


echo "Ihr Kommentar:<br><br>";

echo "</div>";

echo "<div class='values'>";
echo $_SESSION['infos']["shape"]."<br>";
// echo $_SESSION['infos']["payMethod"]."<br>";
// echo $_SESSION['infos']["delivery"]."<br>";


// echo $_SESSION['infos']["comment"]."<br>";

echo "</div>";

echo "<div class='pageContent'>";
echo "<br><p>Ihre Bestellung wird nun verarbeitet und sie erhalten ein Mail mit einem Link um den Status zu überwachen.</p>";
echo "</div>"; //End of pageContent


// echo '<script type="text/javascript">';
// echo "window.confirm(\"Hello\")";
// echo '</script>';
?>


</body>

</html>
