<?php
  class GrootHeaderViewlet implements IViewlet {

    public static function name() {
      return 'header';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }


    //checks if the user and password is correct
    public function login($user=false,$password=false){
        $user = isset($_POST['Loginname']) ? $_POST['Loginname'] : $user ;
        $password = isset($_POST['Password']) ? $_POST['Password'] : $password ;
        return UserHandler::instance()->login($user, $password);
    }



    //checks if the user and password is correct, testfunction
    public function loginMessage($user=false,$password=false){
        if($user OR $password){

          $user = isset($_POST['Loginname']) ? $_POST['Loginname'] : $user ;
          $password = isset($_POST['Password']) ? $_POST['Password'] : $password ;
          if(UserHandler::instance()->login($user, $password)){
            return "User is logged in";//UserHandler::instance()->login($user, $password);
          }else{
            return "User is NOT logged in";//UserHandler::instance()->login($user, $password);
          }
        }else{

        }


    }

    //log out user, if logout-Button is pressed and logut submitted
    public function logout(){
      if(isset($_POST['Logout'])){
        return UserHandler::instance()->logout();
      }
      //var_dump($function);

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
    //GenreModel::distinct('key');
    $selectBox = GenreModel::getTranslatedGenres();
    array_unshift($selectBox, array('value' => '', 'label'=> i('All')));
    $cat = isset($_REQUEST['cat']) ? htmlspecialchars($_REQUEST['cat']) : null;
    //build the select html element
    $selectBoxHtml = Utilities::buildSelectbox($selectBox, $selectName, $cat);

    //Logo
    $html .= '
    <a href="index.php?view=home">
      <div id="'.$divId.'">
          <span class="'.$classIcon.'">'.$grootLogoChar.'</span>
        </div>
    </a>
    ';

  $query_val = isset($_REQUEST['query']) ? htmlspecialchars($_REQUEST['query']) : '';

  //Searchbar
  $html .= '<form id="search" method="GET">
          '.$selectBoxHtml.'
          <input type="hidden" name="view" value="search" />
          <input type="text" name="query" id="query" value="' . $query_val . '" autocomplete="off"/>
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

      //Deside, if user is logged in or not and change appearance
      if(UserHandler::instance()->loggedin()){
        $buttons = '<input type="submit" class="headerbutton" name="Logout" value="Logout">';
        //getting the values from the protected data array via class.basemodel
        if(UserHandler::instance()->user()){
          $_SESSION['Loggedin']['first_name'] = UserHandler::instance()->user()->getValue('first_name');
          $_SESSION['Loggedin']['last_name'] = UserHandler::instance()->user()->getValue('last_name');
        }
        //echo "<pre>";
        var_dump(UserHandler::instance()->user());
        if(isset($_SESSION['Loggedin']['first_name']) AND isset($_SESSION['Loggedin']['last_name'])){
          $firstName = $_SESSION['Loggedin']['first_name'];
          $lastName = $_SESSION['Loggedin']['last_name'];
        }else{
          $firstName = "";
          $lastName = "";
        }

        $greeting = i('Hello');
       $loginMask = $greeting.' '.$firstName.' '.$lastName;
      }else{
        $buttons = '<input type="submit" class="headerbutton" name="Login" value="Login"/>';
        $loginMask = ''.i("User").': <input class="input3 " name="Loginname"  style="width:90px;height:19px;margin:1px;"></input>  <br />
    '.i("Password").': <input class="input3 " name="Password" style="width:90px;height:19px;margin:1px;"></input>  <br />';
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
      $this->logout();
      $this->login();
      return $this->makeMenu();


  }

  public function ajaxCall() {

  }

}
?>