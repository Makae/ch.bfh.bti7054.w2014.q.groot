<?php
  class GrootNaviViewlet implements IViewlet {

    public static function name() {
      return 'navi';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters

    }

//creates the
public function makeMenu(){

  //Label & class definition
  $idDiv = "sub-menu";
  $classUl = "menu";
  $classLi = "stdanimation1_2";
  $classSpan = "stdanimation1_2";
  $classA = "stdanimation1_4";

  //array mit link, icon, label
  // mit i übersetzen
  $naviArray[] = array("link" => "index.php?view=home", "icon" => "icon_house_alt", "label" => "Home" );
  $naviArray[] = array("link" => "index.php?view=profile", "icon" => "icon_profile", "label" => "Profile" );
  $naviArray[] = array("link" => "index.php?view=categories", "icon" => "icon_tag", "label" => "Categories" );
  $naviArray[] = array("link" => "index.php?view=shoppingcart", "icon" => "icon_cart", "label" => "Shopping Cart" );
  $naviArray[] = array("link" => "index.php?view=wishlist", "icon" => "icon_gift", "label" => "Wishlist" );
  $naviArray[] = array("link" => "index.php?view=hotlist", "icon" => "icon_grid-2x2", "label" => "Hotlist" );


  $linkList = "";

  //create a list item for every array found
  foreach($naviArray as $navipoint){
    //do translation
    $navipoint["label"] = i($navipoint["label"]);

    $linkList .= '
            <li class="'.$classLi.'">
              <span class="'.$classSpan.' '.$navipoint["icon"].'"></span>
              <a class="'.$classSpan.'" href="'.$navipoint["link"].'">'.$navipoint["label"].'</a>
            </li>
    ';
  }

  $html = "";
 $html = '<div id="'.$idDiv.'">
          <ul class="'.$classUl.'">
            '.$linkList.'
          </ul>
        </div>';

        return $html;



  /*
        return '<div id="sub-menu">
          <ul class="menu">
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_house_alt"></span>
              <a class="stdanimation1_4" href="index.php?view=home">Home</a>
            </li>
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_profile"></span>
              <a class="stdanimation1_4" href="index.php?view=profile">Profil</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_tag"></span>
              <a class="stdanimation1_4" href="index.php?view=categorie">Kategorien</a>
            </li>
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_cart"></span>
              <a class="stdanimation1_4" href="index.php?view=shoppingcart" >Shopping Cart</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_gift"></span>
              <a class="stdanimation1_4" href="index.php?view=shop">Ipsum</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_grid-2x2"></span>
              <a class="stdanimation1_4">Doloret</a>
            </li>
          </ul>
        </div>';
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