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
    //Todo generate list from DB
//var_dump(__METHOD__);
//var_dump(Utilities::wiki("Metallica"));
  //$bookList = BookModel::getData();
    $bookList = BookModel::findList(null,null);
 //  echo "<pre>";
//var_dump($bookList);

    //id und class Bezeichnungen der HTML Elementen
    $idContent = "content";
    $classProduct = "product";
    $classImage = "img-preview";
    $classDescription = "description";
    $classDescriptionText = "description-text";
    $label1 = "label1";

    //local config
    $maxDescriptionCharlenght = 300;
    $imagePath = "/src/theme/images/";

    //translations
    $label_prefix = ": ";
    $lang_title = i("Title").$label_prefix;
    $lang_author = i("Author").$label_prefix;
    $lang_description = i("Description").$label_prefix;
    $lang_price = i("Price").$label_prefix;
    $lang_available = "Available".$label_prefix;
    $lang_pageTitel = i("Home");
    $lang_isbn_nr = "ISBN NR";

//var_dump(Utilities::wiki("Metallica"));
    //detail link
    $detailProductLink = "index.php?view=productdetail";
    $textDetails = i('To the details');
    //Product array, TODO get from MYSQL DB
    //$products = array();
    $products = $bookList;
    //TODO Array aus DB holen und verifizieren
    foreach($products as $book){
    // var_dump($book);
      //too long text?
      if(strlen ( $book['description'] ) > $maxDescriptionCharlenght)
      {
        $modDescription = substr ( $book['description'] , 0 , $maxDescriptionCharlenght );
        $modDescription = $modDescription . "...";
        //var_dump($modDescription);
      }else{
        //not too long, display it all
         $modDescription = $book['description'];
      }
 /*
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
        */
        $book['author'] = trim($book['author']);
         $htmlContent .= "
        <div class=\"$classProduct\">
          <div class=\"col col_3_12\"><img class=\"$classImage\" src=\"".$book['cover']."\"  /></div>
          <div class=\"$classDescription col col_9_12\">
           <p><div class=\"$label1\">$lang_title</div>{$book['title']}</p>
           <p><div class=\"$label1\">$lang_author</div><span data-wiki=\"{$book['author']}\">{$book['author']}</span></p>
           <div class=\"$classDescriptionText\"><div class=\"$label1\">$lang_description</div>$modDescription</div>
           <p><div class=\"$label1\">$lang_price</div> {$book['currency']} {$book['price']}</p>
           <p><div class=\"$label1\">$lang_available</div>{$book['available']}</p>
           <a href=\"$detailProductLink&id={$book['isbn']}\" class=\"button button-primary clearfix\">{$textDetails}</a>
          </div>
        </div>";

    }
//print_r($htmlContent);

$htmlContentBody = "
          <h1> $lang_pageTitel</h1>
           $htmlContent
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