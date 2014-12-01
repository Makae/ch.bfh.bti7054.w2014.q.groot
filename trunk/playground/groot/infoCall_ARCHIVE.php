<html>
<head>
<script type="text/javascript" src="functions.js"></script>
</head>
<link rel="stylesheet" href="styles.css" />
<body>


<?php
include_once 'utility.php';
$lan = getCurrentLanguage();
$productID = $_GET["productID"];

//Dieser, wie auch jeder andere Content wird im index.php aufgerufen. Dort ist der inhalt vom .contentArea div ummantelt

echo "<p id = 'contentTitle'>Info Seite";

echo "<h2>Product: $productID</h2>";


echo "<div class=addInfos>";

echo "<p> Das Buch handelt von einem kleinen Mädchen, das der Grossmutter einen Korb mit Essen bringen will.<br>Auf dem Weg zur Grossmutter muss es durch den Wald und trifft auf einen Wolf
		.<br> Glücklicherweise ist das kleine Mädchen bewaffnet.<br><br></p>";


//additional Options Form
echo "<form div='infoForm' action='index.php?view=order&lan=$lan' method='post' name='infoForm'>";
echo "<h2>Options</h2>";

echo "<select name ='shape' size='1'>";
	echo "<option value='EBOOK'>E-Book</option>";
	echo "<option value='Paperback'>Paperback</option>";
echo "</select><br><br>";

echo "<h2>Shipping<br></h2>
<input type='radio' name='radio_list[]' value='Standard' checked='checked'>Standard</input><br>
<input type='radio' name='radio_list[]' value='By plane'>By plane</input><br>
<input type='radio' name='radio_list[]' value='By the Flash'>By the Flash</input>
<br><br>";

//Auch wenn sich Radiobuttons für single-select aufdrängen, ist es hier übungshalber trotzdem mit checkboxes gemacht
echo "<h2>Payment<br></h2>"; //Wenn man ohne JavaScript auf eine Box gehen will, muss man Radiobuttons nehmen
echo "<input type='checkbox' name='paymentBox[]' onclick='uniqueCheck(this)' value='Creditcard'>Creditcard</input><br>";
echo "<input type='checkbox' name='paymentBox[]' onclick='uniqueCheck(this)' value='Invoice'>Invoice</input><br>";
echo "<input type='checkbox' name='paymentBox[]' onclick='uniqueCheck(this)' value='Monopoly Dollars'>Monopoly Dollars</input>";
echo "<br><br>";

echo '<textarea name="comments" rows=5 cols=80 placeholder="Insert your comment here..."></textarea>';

echo "<br><br>";
echo "If you have completed the necessary informations click on the  \"Confirm-\"Button in order to proceed to the checkout.<br><br>";
echo "<input type='submit' onclick='return nextValidation()' value='Next'></input>";
//return confirmIT() wird verwendet um bei einem canceln, den zurückgegebenen false wert auch ans HTML "zurückzugeben"

/*
=> Erklärung aus dem Web:
 * Returning false from the function, will abort the effect of the checking. 
 * Because the native of functions that written hardcoded into html properties (it became some new local function), 
 * writing the html without the word "return" will just run the function, 
 * and lose its returning value, as if you've wrote:

 */
echo "</form></div>";
//END of additional Options Form


echo "</div>"; //End of addInfos Div



?>
</body>

</html>