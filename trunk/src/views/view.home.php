<?php
  //generates the main content of the home site
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
    $bookList = BookModel::findList(null,null);

    //id und class Bezeichnungen der HTML Elementen
    $idContent = "content";
    $classProduct = "product";
    $classImage = "img-preview";
    $classDescription = "description";
    $classDescriptionText = "description-text";
    $label1 = "label1";

    //local configs, path are saved in book db table
    $maxDescriptionCharlenght = 300;
    $imagePath = "/src/theme/images/";

    //translations
    $label_prefix = ": ";
    $lang_title = i("Title").$label_prefix;
    $lang_author = i("Author").$label_prefix;
    $lang_description = i("Description").$label_prefix;
    $lang_price = i("Price").$label_prefix;
    $lang_available = i("Available").$label_prefix;
    $lang_pageTitel = i("Home");
    $lang_isbn_nr = i("isbn");

    //detail link
    $detailProductLink = "index.php?view=productdetail";
    $textDetails = i('To the details');

    $products = $bookList;
    // Array aus DB holen und verifizieren
    foreach($products as $book){

      //too long text?
       $modDescription = Utilities::cutText($book['description'], $maxDescriptionCharlenght);



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

  $htmlContentBody = "
          <h1> $lang_pageTitel</h1>
           $htmlContent
  ";

  return $htmlContentBody;
}

  public function ajaxCall() {
    // we will return the value as json encoded content
    return json_encode('asdf');
  }
}
?>