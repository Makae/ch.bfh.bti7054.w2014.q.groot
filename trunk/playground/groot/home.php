<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<link rel="stylesheet" href="styles.css" />
</head>

<body>
<?php
include_once ('dictionary.php');

if(isset($_GET["lan"])) $lan = $_GET["lan"];
	else $lan = "de";
	
	
echo '<p id="contentTitle">';
echo translate("homeText", $lan)."</p>";

// function fillTemplate(&$template) { //Wichtig, damit man das template File selber verändert mit Ampersand arbeiten

// $template = str_replace("@content@", "INHALT", "Das ist der Inhalt der Startseite. Dient als Testumgebung für Tasks 12+. Für Ajax Funktion klicke auf das Bild.");

// }
// $template = file_get_contents("template.html");
// fillTemplate($template);
$template = file_get_contents("template.html");
$template = str_replace("@content@", "INHALT", "Das ist der Inhalt der Startseite. Dient als Testumgebung für Tasks 12+. Für Ajax Funktion klicke auf das Bild.");
echo $template;


//Bild einfügen und wenn man drüber fährt gibt es Info dazu aus
?>
<script type="text/javascript">

function callAjax() {

	console.log("Called AJAX");
	var area = document.getElementById("area");
	
	ajaxCall = new XMLHttpRequest();

	ajaxCall.onreadystatechange = function() {
	console.log("enter function");
		if(ajaxCall.readyState==4) {
			console.log("STATE4");
			area.value = ajaxCall.responseText;	//xmlhttprequest.responsetext handelt Strings die zurückgeben werden
			//Es jinnt eub XNK zurück:
		
			//area = ajaxCall.responseXML;
		}
	};

	//Und hier kommt der Call zum Server: "Request for Object"
	ajaxCall.open("GET", "AJAX_geass.php?value=test", true);
	ajaxCall.send(null);
}


</script>
<div id='geass'>
<img src="geass.jpg" height='10%' width="10%" border="2" onclick="callAjax()">
<textarea id='area' rows="10" cols="30"></textarea>
</div>




<!-- CLIENTSEITIGE INPUT VALIDIERUNG -->
<br><div id='inputval'>
<script type="text/javascript">
function check() {
	value = document.getElementById('value').value;
	

	regex = /[\d]+[a-z]+/;
	regex2 = /[F][A][B]/;
	regex3 = /(\+|-)?[0-9]+(\.\d{0,2})/;
	//password, alphanummerisch, 6-8 Zeichen, beginnent mit einem Buchstaben
	regex4 = /[a-zA-z][\w]{5,7}/;
	//integer from 0-255
	intReg = /^([0-9]?[0-9]?)$/;

	//^(0?[1-9]|[1-9][0-9])$
	password
	
	if(intReg.test(value))
		res="ok";
	else
		res="NOK";
		document.getElementById("result").value = res;
}

</script>

<br>Order Quantity (1-99):<input type='text' id='value'>
<button type="submit" onclick="check()" name='CHECK'>CHECK</button>
<br><br><br>
Resultat:
<textarea id='result' rows="2" cols="10"></textarea>

<?php 

echo "<form action='http://localhost/groot/index.php?view=home&lan=de' method=\"POST\">";
echo "<input name='text'>";
echo "<input type=\"submit\" value=\"Match?\"><br />";

//regex um zu schauen ob irgendwo eine jahrzahl ist
$regex = '/19[0-9]+/';
$matches = array();

if (isset($_POST["text"])) {
	if (preg_match_all($regex,$_POST["text"], $matches)) {
		echo "Successfully matched";
		echo print_r($matches);
		
	}
	else echo "No match";
}



?>













</div>









</body>

</HTML>
