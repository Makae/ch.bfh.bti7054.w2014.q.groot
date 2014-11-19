<!DOCTYPE html>
<html><head><link rel="stylesheet" href="styles.css" /></head>
<script type="text/javascript" src="functions.js"></script>
<body>
     
     
      <?php 

      //Auslesen in welcher view wir sind - um nachher die gewählten Links einzufäreben
      $view="";
      if(isset($_GET["view"]))
      	$view = $_GET["view"];
      
      
      $linksArray = array(
      		"linkTarget" => array("index.php?view=home", "index.php?view=products", "index.php?view=profile", "index.php?view=categories", "index.php?view=".urldecode("shopping card")),
      		"linkKeyNames" => array("home", "products", "profile", "categories", "shopping card"),
      );
	
		

   function buildMenu($language) {
   	
  		global $view;
    	global $linksArray;
    	    		
    	
    	echo '<ul class="navMenuList">'; //CSS für die unsorted List
    	$arraySize = count($linksArray['linkKeyNames']);  //sizeof würde nur 2 zurückgeben, da das linksArray "nur" 2 Arrays enthält
    	
    	for($i=0; $i<$arraySize; $i++) {
    	    		
    		$linkTarget = $linksArray["linkTarget"][$i]."&lan=$language";

    		$linkKeyName = $linksArray["linkKeyNames"][$i];
    		
       		include_once('dictionary.php');
			$linkName =  translate($linkKeyName, $language);		
    		//bei jedem for loop gibt es einen neuen li-Eintrag:
    		echo '<li>';
    			if(strcasecmp($linkKeyName, urldecode($view))==0)
    			$linkClass = "chosenLink"; //ein Match für den linknamen, der mit der aktuellen view übereinstimmt
    		else
    			$linkClass = "normalLink";
   
    		echo "<a class='$linkClass' href='$linkTarget' onmouseover='mouseOver(this)' id='$linkName'>$linkName</a></li>";
    		
    };
    echo "</ul>";
    
    }
   

    ?>
  
      
</body>

</html>	