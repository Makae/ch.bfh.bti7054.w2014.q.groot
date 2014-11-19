<!DOCTYPE html>
<html><head><link rel="stylesheet" href="styles.css" /></head>
<script type="text/javascript" src="functions.js"></script>
<body>
     
     
      <?php 

      //Auslesen in welcher view wir sind - um nachher die gew�hlten Links einzuf�reben
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
    	    		
    	
    	echo '<ul class="navMenuList">'; //CSS f�r die unsorted List
    	$arraySize = count($linksArray['linkKeyNames']);  //sizeof w�rde nur 2 zur�ckgeben, da das linksArray "nur" 2 Arrays enth�lt
    	
    	for($i=0; $i<$arraySize; $i++) {
    	    		
    		$linkTarget = $linksArray["linkTarget"][$i]."&lan=$language";

    		$linkKeyName = $linksArray["linkKeyNames"][$i];
    		
       		include_once('dictionary.php');
			$linkName =  translate($linkKeyName, $language);		
    		//bei jedem for loop gibt es einen neuen li-Eintrag:
    		echo '<li>';
    			if(strcasecmp($linkKeyName, urldecode($view))==0)
    			$linkClass = "chosenLink"; //ein Match f�r den linknamen, der mit der aktuellen view �bereinstimmt
    		else
    			$linkClass = "normalLink";
   
    		echo "<a class='$linkClass' href='$linkTarget' onmouseover='mouseOver(this)' id='$linkName'>$linkName</a></li>";
    		
    };
    echo "</ul>";
    
    }
   

    ?>
  
      
</body>

</html>	