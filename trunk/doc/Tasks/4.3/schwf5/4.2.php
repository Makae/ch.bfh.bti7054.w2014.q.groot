<!--	13.10.2014 schwf5: LinkListe gem�ss Aufgabe 4.2 aufbauen 
		Sp�ter mit Values der eingebundenen MySQL DB abf�llen -->
		
      <?php 
      
      $linksArray = array(
      		"linkTarget" => array("kategorien.html", "profil.html", "wunschzettel.html", "warenkorb.html"),
      		"linkName" => array("Kategorien", "Profil", "Wunschzettel", "Warenkorb")
      );
	
		$arraySize = count($linksArray['linkName']);  //sizeof w�rde nur 2 zur�ckgeben, da das linksArray "nur" 2 Arrays enth�lt


	   for($i=0; $i<$arraySize; $i++) {
      	echo "<li><a href= {$linksArray["linkTarget"][$i]} class='stdanimation1_2'>".$linksArray["linkName"][$i]."</li></a>";
      }
             
      ?>