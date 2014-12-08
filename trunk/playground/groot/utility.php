<?php

//15.11: ersetzt durch Cookieauslesen
 
//function getCurrentLanguage() {
// if(isset($_GET["lan"]))
// 	return $_GET["lan"];
// else
// 	return "de";
// }

function search() {
	
	// load Zend classes
	require_once 'Zend/Loader.php';
	Zend_Loader::loadClass('Zend_Rest_Client');
	// define category prefix
	$prefix = 'hollywood';
	
	// initialize REST client
	$wikipedia = new Zend_Rest_Client('http://en.wikipedia.org/w/api.php');
	// set query parameters
	$wikipedia->action('query'); 
	$wikipedia->list('allcategories'); //All list queries return a limited number of results.
	
	$wikipedia->acprefix($prefix); 
	$wikipedia->format('xml');
	// perform request and iterate over XML result set
	$result = $wikipedia->get();
	
	
	//echo "<ol>";
	    foreach ($result->query->allcategories->c as $c) {
	     //<a href="http://www.wikipedia.org/wiki/Category: 
	       echo $c."<br>";   
	    }
}


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