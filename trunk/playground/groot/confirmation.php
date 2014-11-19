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
<?php

session_start();
include_once 'dictionary.php';
include_once 'utility.php';
$lan = getCurrentLanguage();

echo "<p id = 'contentTitle'>".translate("confirmationMessage", $lan)."</p>";

echo "<div class='subjects'>";
echo "Ausgew�hlte Form: <br>";
echo "Ausgew�hlte Zahlungsart: <br>";
echo "Ausgew�hlte Versandart:<br>";

echo "Vorname: <br>";
echo "Nachname: <br>";
echo "Strasse:<br>";
echo "Nummer:<br>";
echo "City:<br>";
echo "Land:<br>";

echo "Ihr Kommentar:<br><br>";

echo "</div>";

echo "<div class='values'>";
echo $_SESSION['infos']["shape"]."<br>";
echo $_SESSION['infos']["payMethod"]."<br>";
echo $_SESSION['infos']["delivery"]."<br>";

echo $_POST['firstname']."<br>";
echo $_POST['lastname']."<br>";
echo $_POST['streetname']."<br>";
echo $_POST['streetnr']."<br>";
echo $_POST['city']."<br>";
echo $_POST['country']."<br>";

echo $_SESSION['infos']["comment"]."<br>";

echo "</div>";

echo "<div class='pageContent'>";
echo "<br><p>Ihre Bestellung wird nun verarbeitet und sie erhalten ein Mail mit einem Link um den Status zu �berwachen.</p>";
echo "</div>"; //End of pageContent


// echo '<script type="text/javascript">';
// echo "window.confirm(\"Hello\")";
// echo '</script>';
?>


</body>

</html>
