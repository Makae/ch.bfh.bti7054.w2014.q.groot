<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<link rel="stylesheet" href="content.css" />
</head>

<body>
<?php
include_once ('dictionary.php');

if(isset($_GET["lan"])) $lan = $_GET["lan"];
	else $lan = "de";
	
	
echo '<p id="contentTitle">';
echo translate("categorieTitle", $lan);


?>
</body>

</HTML>
