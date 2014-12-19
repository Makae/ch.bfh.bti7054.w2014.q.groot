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
echo translate("welcome", $lan);

// $client = new SoapClient("http://www.webservicex.net/geoipservice.asmx?WSDL"); 

//Im Beschrieb steht des SOAP Request steht: <IPAddress>string</IPAddress>
//XML-Element= Identifiere in einem associated Array und der Value zu diesem Index im Array entspricht dann der TextValue

//Das Resultset besitzt als Attribute die Elemente
// $result = $client->GetGeoIP(array("IPAddress" => "83.251.30.62")); //change was made here

// echo "<br>Die IP:83.251.30.62 kommt aus: ";
// echo $result->GetGeoIPResult->CountryName ." mit dem Countrycode: ".$result->GetGeoIPResult->CountryCode;


//echo "<a href=\"".add_param($url,"lan","en")."\">EN</a> ";


//Aufbau des Menus mit Links entsprechend der ausgewählten Sprache


$DB = new mysqli("localhost", "root", "", "test");
if(isset($DB)) {
echo "<div>erstellt!</div>";
}

$DB->query("CREATE TABLE member (id int NOT NULL AUTO_INCREMENT, vorname VARCHAR(20), nachname VARCHAR(20), Wohnort VARCHAR(20), PRIMARY KEY (id))");
//$DB->query("INSERT INTO member VALUES('null', 'Fabian', 'Schwab', 'Zollikofen')");
$res = $DB->query("SELECT * from member");

$myArray = $res->fetch_assoc();
echo var_dump($myArray);

while ($person = $res->fetch_object()) {
	echo $person->vorname;
}


$movies = simplexml_load_file("movies.xml"); 
$newMovie=$movies->addChild("checksum", "test"); 
//$newMovie->addChild("title", "Lord of the Rings"); 

echo $movies->checksum;

    foreach ($movies->movie as $movie) 
      echo "<h3>".$movie->title."</h3>"; 
echo $movies->asXML();




?>
</body>

</HTML>
