<!--	13.10.2014 schwf5: LinkListe gemäss Aufgabe 4.2 aufbauen 
		Später mit Values der eingebundenen MySQL DB abfüllen -->
		
      <?php 
      
      $linksArray = array(
      		"linkTarget" => array("kategorien.html", "profil.html", "wunschzettel.html", "warenkorb.html"),
      		"linkName" => array("Kategorien", "Profil", "Wunschzettel", "Warenkorb")
      );
	
		$arraySize = count($linksArray['linkName']);  //sizeof würde nur 2 zurückgeben, da das linksArray "nur" 2 Arrays enthält


	   for($i=0; $i<$arraySize; $i++) {
      	echo "<li><a href= {$linksArray["linkTarget"][$i]} class='stdanimation1_2'>".$linksArray["linkName"][$i]."</li></a>";
      }
             
      ?>