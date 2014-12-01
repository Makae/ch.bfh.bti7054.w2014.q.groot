<?php
  class GrootHeaderViewlet implements IViewlet {

    public static function name() {
      return 'header';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    //checks if the user and password is correct
    public function checkLogin($name,$password){

      //wird vom userhandler gemacht
      //TODO
      return true;


    }

    //checks if the user and password is correct
    public function login($user=false,$password=false){

var_dump($_POST);
        $user = isset($_POST['Loginname']) ? $_POST['Loginname'] : $user ;
        $password = isset($_POST['Password']) ? $_POST['Password'] : $password ;
        return UserHandler::login($user, $password);

        //if( && isset($_POST['Password']) && trim($_POST['Loginname']) != "" && trim($_POST['Password']) != "" &&GrootHeaderViewlet::checkLogin($name,$password)){
           //var_dump("waoeifjwaofeiuaoefha XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
          
        //}



    }

    //checks if the user and password is correct
    public function logout($function){
        return UserHandler::logout();
    }




    //creates the Menu from a Navi Array
  public function makeMenu(){



  #label of selectbox
  $selectName = "cat";
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
  $selectBox[] = array("value" => "4", "label" => "Children's book" );
  $selectBox[] = array("value" => "5", "label" => "Professions" );
  $selectBox[] = array("value" => "6", "label" => "Art" );
  $selectBox[] = array("value" => "7", "label" => "Sport" );

  //build the select html element
  $selectBoxHtml = Utilities::buildSelectbox($selectBox, $selectName);

  //Logo
  $html .= '
  <a href="index.php?view=home">
    <div id="'.$divId.'">
        <span class="'.$classIcon.'">'.$grootLogoChar.'</span>
      </div>
  </a>
  ';

<<<<<<< Updated upstream
//Searchbar
$html .= '<form id="search">
=======
$html .= '<form id="search" method="POST">
>>>>>>> Stashed changes
        '.$selectBoxHtml.'
        <input type="hidden" name="view" value="search" />
        <input type="text" name="query" id="query" />
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

      //Add a login form
      //$t = time()+60*60*24*30; // expires in 30 days
      //setcookie("loginname", $_POST["firstname"], $t);
      //setcookie("password", $_POST["lastname"], $t);

    //Deside, if user is logged in or not and change appearance
    if(Userhandler::loggedin()){
      $buttons = '<input type="submit" class="headerbutton" value="Logout">';
      
      $loginMask = 'Hello '.Userhandler::user();
    }else{
      $buttons = '<input type="submit" class="headerbutton" value="Login"/>';
      $loginMask = 'Loginname: <input class="input3 " name="Loginname"  style="width:90px;height:18px;"></input>  <br />
  Password: <input class="input3 " name="Password" style="width:90px;height:18px;"></input>  <br />';
    }

     // $html .= "<div id='login' class='login' style='float:left'>";
      $html .= '<div style="float:right;margin:0px;padding:0px;text-align:right;color:#FFFF00;" >
<form action="" method="POST">
  '.$loginMask.'
  '.$buttons.'
</form>
</div>
      ';

  return $html;
}

  public function render() {
      // Here comes the rendering process

      $this->login();
      return $this->makeMenu();


  }

  public function ajaxCall() {

  }

}
?>