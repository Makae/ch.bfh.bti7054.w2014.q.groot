<?php 
$language = "default";
setcookie("language", $language);

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
			<form id="search">
				<select name="category">
					<option value="1">Fantasy</option>
					<option value="2">Horror</option>
				</select> <input type="text" name="search_text" id="search_text" />
				<button type="submit" name="search" value="search">Suchen</button>
			</form>

			
<?php 

/*Bau des Menus im Header */
      echo '<ul class="menu menu-main">';
      
      $linksArray = array(
      		"linkTarget" => array("kategorien.html", "profil.html", "wunschzettel.html", "warenkorb.html"),
      		"linkName" => array("Kategorien", "Profil", "Wunschzettel", "Warenkorb"));
	
		$arraySize = count($linksArray['linkName']);  //sizeof würde nur 2 zurückgeben, da das linksArray "nur" 2 Arrays enthält

	   for($i=0; $i<$arraySize; $i++) {
      	echo "<li><a href= {$linksArray["linkTarget"][$i]} class='stdanimation1_2'>".$linksArray["linkName"][$i]."</li></a>";
      	}
      	
      echo "</ul>";       
      ?>   
		</div> 
</div>


<!-- Bau des Navigationsmenus -->

<div class="navigation">
<?php
include_once('dictionary.php');
 
$url = $_SERVER['PHP_SELF']; //aktuelle Page reinlesen

if(isset($_GET["lan"]))
	$lanID=$_GET["lan"];
else 
	$lanID="de";

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
include ('utility.php');
$currentView = getCurrentView(); 

$urlDE = "index.php?view=".urlencode($currentView).$productID."&lan=de";
$urlEN = "index.php?view=".urlencode($currentView).$productID."&lan=en";

echo '<div class="langLink">';
echo "<a href = $urlDE>DE</a>";	
echo " / ";
echo "<a href = $urlEN>EN</a>";
echo "</div>";

//Vor der Cookielösung wurde die Sprachauswahl so gelöst:
/*
echo '<div class="langLink">';
echo "<a href = $urlDE>DE</a>";	
echo " / ";
echo "<a href = $urlEN>EN</a>";
echo "</div>";
*/
?>
</div>

<!-- Contentbereich || Dieses Div "ContentArea" wird immer gleich gebaut und mit verschiedenen -->

<div class="contentArea"> 
<?php 	

openRequestedView();

?>
      
</div>


</body>
</html>




