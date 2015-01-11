<?php
//
// Shows a Product (Book) in its detail
// you can add an amout to the shopping cart here
//
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
    $button1 = i("Buy");

    //Product array
    $products = array();

    //get the product list
    $products = BookModel::findList(null,null);

    //save id
    if(isset($_GET['id']))
    $_SESSION['productdetail_id_selected'] = $_GET['id'];

    //create an arraylist
    foreach($products as $book){
       if($_SESSION['productdetail_id_selected'] != $book['isbn']){
          continue;
        }

      $paragraph = Utilities::buildParagraph($book);

      //too long text?
      if(strlen ( $book['description'] ) > $maxDescriptionCharlenght)
      {
        $book['description'] = substr ( $book['description'] , 0 , $maxDescriptionCharlenght );
        $book['description'] = $book['description'] . "...";
      }else{
        //not too long, display it all
         $modDescription = $book['description'];
      }

/*
 * schwf5: Element in Warenkorb legen
 */
$note = "";
$found = false;

//Auslesen der BuchID
if(isset($_GET["id"]))
$currentID = $_GET["id"];
else
	$currentID = 0;



//Prüfen ob Seite mit added action geladen wurde (d.h. dass Buch in Korb gelegt wurde)
if((isset($_GET["action"])) && $_GET["action"]=="added") {

	$amount = $_POST["amountSelection"];
	//Seite wurde neu geladen. Prüfen, ob bereits ein Warenkorb existiert

	//Korb existiert schon. Items also in den Warenkorb hinzufügen
	if(isset($_COOKIE["shoppingCart"])) {

		//Prüfen, ob dieser Artikel schon hinzugefügt wurde. Wenn ja, den Amount hinzutun
		$cartArray = json_decode($_COOKIE["shoppingCart"]);

		foreach($cartArray as $index) {

			if($index->ID == $currentID) {
				$note = "Buch war schon im Korb - Anzahl aktualisiert";
				$index->amount += $amount;
				setcookie("shoppingCart", json_encode($cartArray));
				$found = true;
			}
		}

		if(!$found) {
			array_push($cartArray, array ("ID"=>$currentID, "amount"=>$amount));
			setcookie("shoppingCart", json_encode($cartArray));

		}
	}

	//neuen Korb machen mit erstem Item
	else  {
	$cartArray = array	(
		array ("ID"=>$currentID, "amount"=>$amount));
	setcookie("shoppingCart", json_encode($cartArray));
	}

	//


}


else
	;

$htmlContent .= "
        <div class=\"$classProduct\">
        <div class=\"$classImage\"><img  src=\"".$book['cover']."\"  />
          </div>
          <div class=\"$classDescription\">

           $paragraph

              <div>
                  <br>".i('Amount').":
                  <form action='index.php?view=productdetail&id=$currentID&action=added' method='post'>
                  <select name='amountSelection' class='input-border'>

  					 <option value='1'>1</option>
 					 <option value='2'>2</option>
 					 <option value='3'>3</option>
 					 <option value='4'>4</option>
 					 <option value='5'>5</option>

					</select>
					<input class='button button-primary' type='submit' name='submit' value='".i('Add to cart')."' />
					</form>



              </div>

           </div>
        </div>";


    }

//textmessage, after a product was placed in shoppingcart
if(isset($_GET["action"])){
	$buyState= "Produkt wurde in den Warenkorb gelegt.<br>";

} else {
  $buyState="";
}

//display page
$htmlContentBody = "
		<div id=\"content\">
        <span style='color:red'>$buyState</span>
 		$note
          <h1>".$lang_pageTitel."</h1>
           $htmlContent
        </div>

";


return $htmlContentBody;


}

  }
?>