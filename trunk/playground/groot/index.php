<?php
/*
 * AUTOLOAD !!!! Das muss bereits hier geschehen in meinem index File weil:
 * Wenn das erste Mal ein Produkt gekauft wird, wird beim Wechsel zur addToCart.php die Session["cart"] Variable geschrieben.
 * Wenn man dann zu den produkten zurückkehrt und noch ein Produkt auswählt, ist diese Variable gesetzt, aber sie muss auch ausgelesen werden
 * können und hier kommt das Problem:
 * !!!!!!!!!!!! Vor dem Session Start müssen die Klassen eingebunden werden !!!!!!!!!!!!!!!!!!
 * Und da ich mein Session_Start immer im index.php habe und nicht im addToCart, muss das Index die Klassen laden
 */
function __autoload($class_name) {				
	require_once($class_name.".php");
}

session_start();


$pageRebuild = false;

/*Log In / Log Out Procedure */

if(isset($_GET["do"])) {
	if($_GET["do"]=='logOut')
		unset($_SESSION["username"]);
		unset($_SESSION["loggedIn"]);
}


if(isset($_POST["username"])) {
	if(checkCredentials($_POST["username"], $_POST["password"])){
	$_SESSION["username"]=$_POST["username"];
	$_SESSION["password"]=$_POST["password"];
	$_SESSION["loggedIn"]=true;
	} //Wenn ja, die Session Variablen setzen
}

/*END OF Log In / Log Out Procedure */


if (isset($_COOKIE["language"]))
	$lanID = $_COOKIE["language"];
else {
setcookie("language", "de");
$lanID="de";
}

if(isset($_GET["lan"])) {			
	setcookie("language", $_GET["lan"]);
	$lanID=$_GET["lan"];
}

function checkCredentials($username, $password) {
	if($username!="" && $password!="")
		return true;
	else return false;
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="functions.js"></script>
</head>

<body>
	<div id="header">
		<div class="container">
	
<?php 
include_once('utility.php');
//aktuelle View nehmen damit ich die nach dem Login wieder laden kann.


echo "<div id='debugDiv'>".getCurrentView()."<br>";
echo "PLAYGROUND";
if(getCurrentView()=="")
	$view='home';
else $view = getCurrentView();

echo "</div>";

echo "<div class='loginFormDiv'>";
if(isset($_SESSION["loggedIn"])) {
	echo "Logged in as: ". $_SESSION['username'];
		
	echo "<br><a href='index.php?view=$view&lan=$lanID&do=logOut'>Log Out</a>";
}
else 
{
echo "<form action='index.php?view=$view&lan=$lanID' method='post'>";
echo "Username: <input name='username'></input>";
echo "Password <input type='password' name='password'></input>";
echo "<input type='submit' value='LogIn'></input></form></div>"; //End of Div for LoginUser/PW
}

    
?>   
</div> 
</div>


<!-- Bau des Navigationsmenus -->

<div class="navigation">
<?php
include_once('dictionary.php');
 
$url = $_SERVER['PHP_SELF']; //aktuelle Page reinlesen

//Falls man während der Produktauswahl die Sprache wechseln will - bei der Confirmation habe ich das nachher nicht mehr gemacht
if(isset($_GET["productID"]))
	$productID="&productID=".$_GET["productID"];
else
	$productID="";

//Navigationsmenu
echo '<p id="NavHeader">'.translate('navigationList', $lanID);
echo "</p><br>";

//Je nach Auswahl wird der Parameter des aktuellen Scripts verändert, wenn das gemacht wird, wird die gleiche Seite eben mit den neuen Parametern aufgerufen.
//menu wird bei jedem Seitenaufruf neu gebaut.

include_once("menu.php");
buildMenu($lanID);

//DE-EN Auswahl: Bei Klick wird die Seite neu gebaut, aber mit dem richtigen 'lan' Parameter.
echo "<br><br><br>Sprache/Language:<br><br>";

//buildURL mit: aktueller View + 
//include ('utility.php');

$currentView = getCurrentView();
//Bei erstem Besuch ist Sprachenwechsel noch nicht machbar, egal.
$urlDE = "index.php?view=".urlencode($currentView).$productID."&lan=de";
$urlEN = "index.php?view=".urlencode($currentView).$productID."&lan=en";

echo '<div class="langLink">';
echo "<a href = $urlDE>DE</a>";

echo " / ";
echo "<a href = $urlEN>EN</a>";
echo "</div>";

?>

</div>

<!-- Contentbereich || Dieses Div "ContentArea" wird immer gleich gebaut, aber mit verschiedenen Inhalten (=views) -->
<div class="contentArea"> 
<?php 	

openRequestedView();

?>
      
</div>
</body>
</html>




