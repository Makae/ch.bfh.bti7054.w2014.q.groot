<?php

//$_SESSION['infos'] 
$mysqli = new grootDB();

if(isset($_POST["new_username"])) {
$username = $_POST["new_username"];
$pw = $_POST["new_pw"];
$fname = $_POST["forename"];
$sname = $_POST["surename"];
$mysqli->addAccount($username, $pw, $fname, $sname);

}

if(isset($_POST["username_2"])) {
	if($mysqli->checkCredentials($_POST["username_2"], $_POST["pw_2"]));	{
		//redirect to homepage and be logged in
	$_SESSION["userInfo"] = array ("username"=>$_POST["username_2"]);
	echo "Redirect to the homepage";
	
	echo "<script type='text/javascript'>";
	echo "window.open('index.php','_self',false)";
	echo "</script>";
	}
}


echo "New profile has been created. Please log in:<br>";

//Login: Wenn auf Button klickt check auf User Credentials und wenn okay, dann auf Startseite umleiten

echo "<form action='index.php?view=newProfile' method=post>";
echo "Username:<input name='username_2'/><br><br>Password: <input name='pw_2'/>";
echo "<input type='submit' value='LogIn'></form>";



?>