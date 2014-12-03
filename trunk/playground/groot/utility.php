<?php

//15.11: ersetzt durch Cookieauslesen
 
//function getCurrentLanguage() {
// if(isset($_GET["lan"]))
// 	return $_GET["lan"];
// else
// 	return "de";
// }

function getCurrentLanguage() {
	if(isset($_COOKIE["language"]))
		return $_COOKIE["language"];
	else
		return "de";
}


function get_parameter($varName, $default) {
	if(isset($_GET[$varName])) {
		echo urldecode($_GET[$varName]);
		return urldecode($_GET[$varName]);
	}
	else return $default;
}

function getCurrentView() {
	if(isset($_GET["view"]))
		return urldecode($_GET["view"]);
	else return "";
}

function openRequestedView() {

	if(isset($_GET['view']))
	include_once urlencode($_GET['view']).".php"; //Bsp. view = infoCall -> include_once infoCall.php
	else
		require 'welcome.php';
	
}

?>