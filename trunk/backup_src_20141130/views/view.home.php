<?php
  class GrootHomeView implements IView {

    public function name() {
      return 'home';
    }

    public function viewletMainMenu() {
      return null;
    }

    public function viewletNavi() {
      return null;
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
    $classProduct = "product";
    $classImage = "img-preview";
    $classDescription = "description";
    $classDescriptionText = "description-text";
    $label1 = "label1";

    //local config
    $maxDescriptionCharlenght = 333;
    $imagePath = "/src/theme/images/";

    //translations
    $label_prefix = ": ";
    $lang_title = i("Title").$label_prefix;
    $lang_author = i("Author").$label_prefix;
    $lang_description = i("Description").$label_prefix;
    $lang_price = i("Price").$label_prefix;
    $lang_available = "Available".$label_prefix;
    $lang_pageTitel = i("Search");
    $lang_isbn_nr = "ISBN NR";
    

    //detail link
    $detailProductLink = "index.php?view=productdetail";
    
    //Product array, TODO get from MYSQL DB
    $products = array();

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

    $products[] = array('Title' => "Medizinal Studie1",
      'ISBN Number' => "142124",
       'Author' => "Messing Hellbert",
        'Year of publication' => 2001,
         'Price' => 29.95,
         'Currency' => 'CHF',
         'Available' => 'Sofort',
         'Language' => 'Deutsch',
          'Picture' => 'chemibuch.jpg',
      'Description' => 'Ein aussergewöhnlich gutes Buch, da vergeht die Zeit wie im Fluge. Man kann fast nicht so schnell lesen als dass man mitschreiben könnte. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."

Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC

"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accuEinfach fantastisch, 2 von 7 Sterne. Oder noch mehr Zeichen als dass ich die darstellen könnte. ENDE',
'Original language' => 'EN',
'Number of Pages' => '324',
'Version' => '2',
'Type' => 'Hörbuch',
'Genre' => 'Horror',
);

    $products[] = array('Title' => "Medizinal Studie2",
      'ISBN Number' => "142125",
       'Author' => "Messing Querto",
        'Year of publication' => 2001,
         'Price' => 29.95,
         'Currency' => 'CHF',
         'Available' => 'Sofort',
         'Language' => 'Deutsch',
          'Picture' => 'sport.jpg',
      'Description' => 'Ein aussergewöhnlich gutes Buch, da vergeht die Zeit wie im Fluge. Man kann fast nicht so schnell lesen als dass man mitschreiben könnte. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."

Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC

"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accuEinfach fantastisch, 2 von 7 Sterne. Oder noch mehr Zeichen als dass ich die darstellen könnte. ENDE',
'Original language' => 'DE',
'Number of Pages' => '13424',
'Version' => '1',
'Type' => 'Taschenbuch',
'Genre' => 'Kinderbuch',
);

    $products[] = array('Title' => "Medizinal Studie3",'ISBN Number' => "142126", 'Author' => "Hueber Selkis", 'Year of publication' => 2001, 'Price' => 29.95,'Currency' => 'CHF','Available' => 'Sofort','Language' => 'Deutsch', 'Picture' => 'test_medizin.jpg',
      'Description' => 'Ein aussergewöhnlich gutes Buch, da vergeht die Zeit wie im Fluge. Man kann fast nicht so schnell lesen als dass man mitschreiben könnte. "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."

Section 1.10.32 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC

"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accuEinfach fantastisch, 2 von 7 Sterne. Oder noch mehr Zeichen als dass ich die darstellen könnte. ENDE',
'Original language' => 'DE',
'Number of Pages' => '1824',
'Version' => '1',
'Type' => 'Taschenbuch',
'Genre' => 'Fantasy',
);

$_SESSION['products'] = $products;

    //Array erstellen
    //TODO Array aus DB holen und verifizieren
    foreach($products as $book){

      //too long text?
      if(strlen ( $book['Description'] ) > $maxDescriptionCharlenght)
      {
        $modDescription = substr ( $book['Description'] , 0 , $maxDescriptionCharlenght );
        $modDescription = $modDescription . "...";
      }else{
        //not too long, display it all
         $modDescription = $book['Description'];
      }
 
      $htmlContent .= "
        <div class=\"$classProduct\">
          <div class=\"$classImage\"><img  src=\"".$imagePath.$book['Picture']."\"  />
          </div>
          <div class=\"$classDescription\">
           <p><a href=\"$detailProductLink&id={$book['ISBN Number']}\"><div class=\"$label1\">$lang_title</div>{$book['Title']}</a></p>
           <p><div class=\"$label1\">$lang_author</div>{$book['Author']}</p>
           <div class=\"$classDescriptionText\"><div class=\"$label1\">$lang_description</div>$modDescription</div>
           <p><div class=\"$label1\">$lang_price</div> {$book['Currency']} {$book['Price']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Available']}</p>


           <p><div class=\"$label1\">$lang_available</div>{$book['Available']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Available']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['Available']}</p>
          </div>
        </div>";
      
    }
//print_r($htmlContent);

$htmlContentBody = "
        <div id=\"content\">
          <h1> $lang_pageTitel</h1>
           $htmlContent
        </div>
";

return $htmlContentBody;

      /*
      return ' <h1>Suche</h1>
          <div class="product">
            <div class="img-preview"><img  src="theme/images/test_medizin.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=123123">Titel: TDYSDF</a></p>
              <p>Autor: Herbert Janson</p>
              <p class="description-text">Beschreibung: Lasdfa dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 19.95 </p>
              <p>Lieferbar: Sofort</p>
            </div>
          </div>
          <div class="product">
            <div class="img-preview"><img  src="images/chemibuch.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=523123">Titel: Fizz  peng</a></p>
              <p>Autor: Herbert Janson</p>
              <p class="description-text">Beschreibung: werwerpsum dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 44.55 </p>
              <p>Lieferbar: Sofort</p>
            </div>
          </div>
          <div class="product">
            <div class="img-preview"><img  src="images/sport.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=123423">Titel: Sport ist Mord</a></p>
              <p>Autor: Simon Phelps</p>
              <p class="description-text">Beschreibung: Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 22.15 </p>
              <p>Lieferbar: Vergriffen</p>
            </div>
          </div>';
          */
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>