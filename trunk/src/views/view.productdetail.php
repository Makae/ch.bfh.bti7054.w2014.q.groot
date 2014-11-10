<?php
  class GrootProductdetailView implements IView {

    public function name() {
      return 'productdetail';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletNavi() {
      return array();
    }

    public function viewletFooter() {
      return null;
    }

    public function process() {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
    $htmlContent = "";//Main Content
    
    //id und class Bezeichnungen der HTML Elementen
    $idContent = "content";
    $classProduct = "product-detail";
    $classImage = "img-preview-detail";
    $classDescription = "description";
    $classDescriptionText = "description-text-detail";
    $label1 = "label1";

    //local config
    $maxDescriptionCharlenght = 20000;
    $imagePath = "/src/theme/images/";
    $lang_pageTitel = i("Productview");
    $button1 = ("Buy");
    
    //Product array
    $products = array();

    //TSCM TODO get from DB instead from Session..
    $products = $_SESSION['products'];



    /*
    $products[] = array('Title' => "Medizinal Studie",
      'ISBN Number' => "142123", 
      'Author' => "Messing Hellbert", 
      'Year of publication' => 2001,
       'Price' => 29.95,
       'Currency' => 'CHF',
       'Available' => 'Sofort',
       'Language' => 'Deutsch',
       'Picture' => 'test_medizin.jpg',
      'Description' => 'Ein aussergewöhnlich gutes Buch, da vergeht die Zeit wie im Fluge. Man kann fast nicht so schnell lesen als dass man mitschreiben könnte. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."

Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC

"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accuEinfach fantastisch, 2 von 7 Sterne. Oder noch mehr Zeichen als dass ich die darstellen könnte. ENDE',
'Original language' => 'DE',
'Number of Pages' => '245',
'Version' => '1',
'Type' => 'Taschenbuch',
'Genre' => 'Krimi',
);
*/

    //Array erstellen
    //TODO Array aus DB holen und verifizieren
    foreach($products as $book){
// var_dump($book);
// exit;
       if($_GET['id'] != $book['ISBN Number']){
          continue;
        }

      $paragraph = Utilities::buildParagraph($book);

      //too long text?
      if(strlen ( $book['Description'] ) > $maxDescriptionCharlenght)
      {
        $book['Description'] = substr ( $book['Description'] , 0 , $maxDescriptionCharlenght );
        $book['Description'] = $book['Description'] . "...";
      }else{
        //not too long, display it all
         $modDescription = $book['Description'];
      }
 
 /*
      $htmlContent .= "
        <div class=\"$classProduct\">
          <div class=\"$classImage\"><img  src=\"".$imagePath.$book['Bild']."\"  />
          </div>
          <div class=\"$classDescription\">
           <p><div class=\"$label1\">$lang_title</div>{$book['Titel']}</p>
           <p><div class=\"$label1\">$lang_author</div>{$book['Autor']}</p>
           <div class=\"$classDescriptionText\"><div class=\"$label1\">$lang_description</div>$modDescription</div>
           <p><div class=\"$label1\">$lang_price</div> {$book['Waehrung']} {$book['Preis']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Lieferbar']}</p>


           <p><div class=\"$label1\">$lang_available</div>{$book['Lieferbar']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Lieferbar']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Lieferbar']}</p>
          </div>
        </div>";
*/

$htmlContent .= "
        <div class=\"$classProduct\">
        <div class=\"$classImage\"><img  src=\"".$imagePath.$book['Picture']."\"  />
          </div>
          <div class=\"$classDescription\">

           $paragraph
         

              <div>
                <a href='index.php?view=payment&id={$_GET["id"]}'>
                  <input class='buy_button' type='button' value='".$button1."'></input>
                </a>
              </div>
           </div>
        </div>";
  
      
    }
//print_r($htmlContent);

$htmlContentBody = "
        <div id=\"content\">
          <h1>$lang_pageTitel</h1>
           $htmlContent


        </div>
        
";


return $htmlContentBody;


    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>