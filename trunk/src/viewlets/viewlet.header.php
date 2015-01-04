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
    $current_view_url = Controller::instance()->getViewUrl();
    foreach(I18n::availableLanguages() as $lang) {
      $naviArray[] = array("link" => $current_view_url . '&lang=' . $lang,
                           "icon" => "",
                           "cls" => $lang == I18n::lang() ? 'active' : '',
                           "label" => strtoupper($lang));
    }
    //create HTML elements for each navi point
   foreach ($naviArray as $navi){

      $navi['label'] = i($navi['label']);
      $naviElement .= '<li class="' . $navi['cls'] . '"><a class="stdanimation1_2" href="'.$navi["link"].'">'.$navi["label"].'</a></li>';
    }

    $html .= '<ul class="menu menu-main">
          '.$naviElement.'
        </ul>';

      //Deside, if user is logged in or not and change appearance
      if(UserHandler::instance()->loggedin()){
        $mask_cls = 'loggedin';
        $buttons = '<input type="submit" class="button" name="Logout" value="Logout">';
        //getting the values from the protected data array via class.basemodel
        if(UserHandler::instance()->user()){
          //$_SESSION['Loggedin']['first_name'] = UserHandler::instance()->user()->getValue('first_name');
          //$_SESSION['Loggedin']['last_name'] = UserHandler::instance()->user()->getValue('last_name');
        //}
        //echo "<pre>";
       // var_dump(UserHandler::instance()->user());
       // if(isset($_SESSION['Loggedin']['first_name']) AND isset($_SESSION['Loggedin']['last_name'])){
         // $firstName = $_SESSION['Loggedin']['first_name'];
         // $lastName = $_SESSION['Loggedin']['last_name'];
          $firstName = UserHandler::instance()->user()->getValue('first_name');
          $lastName = UserHandler::instance()->user()->getValue('last_name');
        }else{
          $firstName = "";
          $lastName = "";
        }

        $greeting = i('Hello');
       $loginMask = $greeting.' '.$firstName.' '.$lastName;
      }else{
        $mask_cls = 'loggedout';
        $buttons = '<input type="submit" class="button" name="Login" value="Login"/>';
        $loginMask = '<div><label for="Loginname">'.i("User").':</label><input class="" name="Loginname" />  </div>
    <div><label for="Password">'.i("Password").':</label><input class="" type="password" name="Password" />  </div>';
      }

       // $html .= "<div id='login' class='login' style='float:left'>";
        $html .= '<div class="login-mask ' . $mask_cls . '">
                    <form action="" method="POST">
                      <div class="mask">'.$loginMask.'</div>
                      <div class="buttons">'.$buttons.'</div>
                    </form>
                  </div>';

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