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
echo translate("profileText", $lan);


?>

<div class="formData">


<h3><br> Infos zu ihrere Person </h3>
<form action="profilForm.php" method ="get"> 

  First name: <input type="text" value="blabla" name="firstname"><br>
  Last name: <input type="text" name="lastname"> <br>
 Birthday: <input type="text" name="birthday"> <br> 
  Nationality: <input type="text" name="nationality"> <br>
  
  <input type="radio" name="age" value="age_1">not from Hydra <br/><br>
  <input type ="submit" value="Submit"/>
  
</form> 

</div>

</body>

</HTML>
