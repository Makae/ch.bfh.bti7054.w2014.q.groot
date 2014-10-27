<?php
  class GrootHeaderViewlet implements IViewlet {

    public static function name() {
      return 'header';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    //creates the Menu from a Navi Array
public function makeMenu(){


  
  #label of selectbox
  $selectName = "category";
  $divId  = "logo";
  $classIcon = "stdanimation1_4";
  $grootLogoChar = "G";

  //Build html
  $html = "";
  /*
  $html .= '
    <div id="'.$divId.'">
        <span class="'.$classIcon.'">'.$grootLogoChar.'</span>
      </div>
  ';
*/
  #create selectbox from array
  $selectBox[] = array("value" => "1", "label" => "Fantasy" );
  $selectBox[] = array("value" => "2", "label" => "Horror" );
  $selectBox[] = array("value" => "3", "label" => "Thriller" );
  $selectBox[] = array("value" => "4", "label" => "children's book" );
  $selectBox[] = array("value" => "5", "label" => "Professions" );
  $selectBox[] = array("value" => "6", "label" => "Art" );
  $selectBox[] = array("value" => "7", "label" => "Sport" );

  //build the select html element
  $selectBoxHtml = Utilities::buildSelectbox($selectBox, $selectName);

  $html .= '
  <a href="index.php?view=home">
    <div id="'.$divId.'">
        <span class="'.$classIcon.'">'.$grootLogoChar.'</span>
      </div>
  </a>
  ';

$html .= '<form id="search">
        '.$selectBoxHtml.'
        <input type="text" name="search_text" id="search_text" />
        <button type="submit" name="search" value="search">Suchen</button>
      </form>';

  //Build up all the navigation points from an array
  $naviElement = "";
  $naviArray[] = array("link" => "index.php?view=profile", "icon" => "icon_profile", "label" => "Profile" );
  $naviArray[] = array("link" => "index.php?view=categories", "icon" => "icon_tag", "label" => "Categories" );
  $naviArray[] = array("link" => "index.php?view=shoppingcart", "icon" => "icon_cart", "label" => "Shopping Cart" );
  $naviArray[] = array("link" => "index.php?view=wishlist", "icon" => "icon_gift", "label" => "Wishlist" );

//create HTML elements for each navi point
foreach ($naviArray as $navi){

  $navi['label'] = i($navi['label']);
  $naviElement .= '<li><a class="stdanimation1_2" href="'.$navi["link"].'">'.$navi["label"].'</a></li>';
}

$html .= '<ul class="menu menu-main">
        '.$naviElement.'
      </ul>';

  return $html;

/*
return '<a href="index.php?view=home"><div id="logo">

            <span class="stdanimation1_4"  >G</span>
      </div></a>
      <form id="search">
        <select name="category">
          <option value="1">Fantasy</option>
          <option value="2">Horror</option>
          <option value="3">Krimi</option>
          <option value="4">Kinderbuch</option>
          <option value="5">Berufswelt</option>
          <option value="6">Kunst</option>
          <option value="7">Sport</option>
        </select>
        <input type="text" name="search_text" id="search_text" />
        <button type="submit" name="search" value="search">Suchen</button>
      </form>
      <ul class="menu menu-main">
        <li><a class="stdanimation1_2" href="index.php?view=categories">Kategorien</a></li>
        <li><a class="stdanimation1_2" href="index.php?view=profile">Profil</a></li>
        <li><a class="stdanimation1_2" href="index.php?view=wishlist">Wunschzettel</a></li>
        <li><a class="stdanimation1_2" href="index.php?view=shoppingcart">Warenkorb</a></li>
      </ul>';
      */
}

    public function render() {
      // Here comes the rendering process

      return $this->makeMenu();

      
    }

    public function ajaxCall() {

    }

  }
?>