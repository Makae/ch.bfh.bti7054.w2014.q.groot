<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css" />
<script type="text/javascript" src="functions.js"></script>
</head>

<body>

<?php

$language ="";

if(isset($_GET["lang"])) {
	$language = $_GET["lang"];
	setcookie("language", $language);
	
}

echo $_GET["URI"];
echo $language;



?>

</body>
</html>