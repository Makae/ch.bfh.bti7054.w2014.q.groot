<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<link rel="stylesheet" href="styles.css" />
</head>

<body>


<?php
include_once ('dictionary.php');

$lan = getCurrentLanguage();

$mysqli = new grootDB();

echo '<p id="contentTitle">';
echo translate("profileText", $lan)."</p>";

if(isset($_SESSION["userInfo"])) {
	//Dann zeige das Profil an, weil man da schon angemeldet ist
	echo "Willkommen: ". $_SESSION["userInfo"]["username"];
	echo "<br><br><h3>Angaben zu deinem Profil: </h3><br>";
	echo "Vorname: <br>";
	echo "Nachname: <br>";
	
	echo "<input type='submit' value='Save changed values'>";
}
	

else {

echo "<br><br>Melden sie sich an, oder erstellen sie ein neues Profil.";

//Login
echo "<form action='index.php?view=profile&lan=$lan' method='post'>";
echo "<br><br>Username:<input name='username'/> Password: <input name='password'/>";
echo "<input type='submit' value='Log In'/></form>";

//Erstellen eines neuen Profils

echo "<br><br><h3>Erstellen sie ein neues Profil:</h3>";

//Login
echo "<form action='index.php?view=newProfile&lan=$lan' method='post'>";
echo "<br><br>Username:<input name='new_username'/><br><br> Password: <input name='new_pw'/><br><br>";
echo "	Forename:<input name='forename'/><br><br> Surename: <input name='surename'/><br><br>";
echo "<input type='submit' value='Create profile'/>";

}



?>




</body>

</HTML>
