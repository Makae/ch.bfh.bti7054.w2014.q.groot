<?php

  /**
  *
  * This class implements the payment view and process
  * with it, the user can set his adress and choose giftbox options. after the last confirmation, an Email is sent to the user
  */
  class GrootPaymentView implements IView {

    public function name() {
      return 'payment';
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

    //depending on which button was pressed, show a different set of forms
    public function visibility($function){
      $poster = "";
      $result = "";
      $class = "hidden";

      if(isset($_POST['poster'])){
        $poster = $_POST['poster'];
      }else{
        $poster = "none";
      }

        switch($function){

          case "deliveryAddress":
            if($poster == 'none'){
              $result = "";
            }else{
              $result =  $class;
            }
          break;

          case "shippingMethod":
          
            if($poster == 'deliveryAddress'){
              $result = "";
            }else{
              $result = $class;
            }
          break;

          case "paymentMethod":
            if($poster == 'shippingMethod'){
              $result = "";
            }else{
              $result = $class;
            }
          break;

          case "giftBox":
            if($poster == 'paymentMethod'){
              $result = "";
            }else{
              $result = $class;
            }
          break;

          case "orderComplete":
            if($poster == 'giftBox'){
              $result = "";
            }else{
              $result = $class;
            }
          break;


          //default werden !ALLE Forms versteckt. Dann läuft aber etwas nicht rund
          default:
            $result = $class;
          break;


        }

        return $result;



    }


    public function render() {
      // Here comes the rendering process

      $js = '

';



      //add Product to session
      //Only if its not yet there
      if(isset($_SESSION['shoppingCart']['id']) && isset($_GET['id'])){
        if(!in_array($_GET['id'],$_SESSION['shoppingCart']['id'])){
          $_SESSION['shoppingCart']['id'][] = $_GET['id'];
        }
      };

      //add chosen values to session
      //adress data
      if(isset($_POST['lastname']))
        $_SESSION['payment_lastname'] = $_POST['lastname'];
      if(isset($_POST['firstname']))
        $_SESSION['payment_firstname'] = $_POST['firstname'];
      if(isset($_POST['street']))
        $_SESSION['payment_street'] = $_POST['street'];
      if(isset($_POST['plz']))
        $_SESSION['payment_plz'] = $_POST['plz'];
      if(isset($_POST['country']))
        $_SESSION['payment_country'] = $_POST['country'];

      //shipping method
      if(isset($_POST['shippingMethod']))
        $_SESSION['payment_shippingMethod'] = $_POST['shippingMethod'];

      //payment method
      if(isset($_POST['paymentMethod']))
        $_SESSION['payment_paymentMethod'] = $_POST['paymentMethod'];

      //gift box
      if(isset($_POST['giftBox']))
        $_SESSION['payment_giftBox'] = $_POST['giftBox'];
      if(isset($_POST['comment']))
        $_SESSION['payment_comment'] = $_POST['comment'];


      $htmlList = "";

      //translations
      $title1 = i("Delivery Address");
      $title2 = i("Shipping Method");
      $title3 = i("Payment Method");
      $title4 = i("Gift Box");
      $title5 = i("Order");

      $html = "";
      $html .= $htmlList;

      //input all posted Values
      $inputs = Utilities::hiddenInputsFromPost();
      $html .= '
      <div>
        '.$inputs.'
      </div>
      ';



      //Use Userdata if logged in
      if(UserHandler::instance()->loggedin()){
        if(UserHandler::instance()->user()){
          $firstName = UserHandler::instance()->user()->getValue('first_name');
          $lastName = UserHandler::instance()->user()->getValue('last_name');
          $streetname = UserHandler::instance()->user()->getValue('streetname');
          $zip = UserHandler::instance()->user()->getValue('zip');
          $city = UserHandler::instance()->user()->getValue('city');
          $email = UserHandler::instance()->user()->getValue('email');
        }else{
          $firstName = "";
          $lastName = "";
          $streetname = "";
          $zip = "";
          $city = "";
          $email = "";
        }

        $greeting = i('Hello');
       $loginMask = $greeting.' '.$firstName.' '.$lastName;
      }


      

      //a form to submit to myself
      $html .= "<div id='deliveryAddress' class=".GrootPaymentView::visibility("deliveryAddress"). ">";
      $html .= '
      <div class="hidden"><input name="deliveryAddressStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title1.'</h1><br />
        <div class="column1">'.i("first_name").'</div><div class=""><input class="input1 " value="'.$firstName.'" name="firstname"></input></div><br />
        <div class="column1">'.i("last_name").'</div><div class=""><input class="input1" value="'.$lastName.'" name="lastname"></input></div><br />
        <div class="column1">'.i("streetname").'</div><div class=""><input class="input1" value="'.$streetname.'" name="street"></input></div><br />
        <div class="column1">'.i("zip").'</div><div class=""><input class="input1" value="'.$zip.'" name="plz"></input></div><br />
        <div class="column1">'.i("city").'</div><div class=""><input class="input1" value="'.$city.'" name="country"></input></div><br />
        <input type="submit" class="button button-primary" value="'.i("Confirm").'"/><input type="reset" class="button button-primary" value="'.i("Reset").'">
        <input class="input1" type="hidden" name="poster" value="deliveryAddress"></input>
      </form>';
      $html .= '</div>';



      //a form to submit to myself
      $html .= "<div id='shippingMethod' class=".GrootPaymentView::visibility("shippingMethod").">";
      $html .= '
      <div class="hidden"><input name="shippingMethodStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title2.'</h1><br />
        <div class="column2">'.i("Home delivery").'</div><div class="column2"><input type="radio" name="shippingMethod" value="Home delivery" checked></input></div>
        <div class="column2" >'.i("Nearest store").'</div><div class="column2"><input type="radio" name="shippingMethod" value="Nearest Store"></input></div>
        <div class="column2">'.i("Other").'</div><div class="column2"><input type="radio" name="shippingMethod" value="Other"></input></div>
        <div class="bottomButton"><input  type="submit" class="button button-primary" value="'.i("Confirm").'"/><input type="reset" class="button button-primary" value="'.i("Reset").'"></div>
        <input class="input1" type="hidden" name="poster" value="shippingMethod"></input>
      </form>';
      $html .= '</div>';


      //a form to submit to myself
      $html .= "<div id='paymentMethod' class=".GrootPaymentView::visibility("paymentMethod"). ">";
      $html .= '
      <div class="hidden"><input name="paymentMethodStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title3.'</h1><br />
        <div class="column2">'.i("Visa").'</div><div class="column2"><input type="radio" name="paymentMethod" value="Visa" checked></input></div>
        <div class="column2">'.i("Postfinance").'</div><div class="column2"><input type="radio" name="paymentMethod" value="Postfinance"></input></div>
        <div class="column2">'.i("Maestro").'</div><div class="column2"><input type="radio" name="paymentMethod" value="Maestro"></input></div>
        <div class="column2">'.i("Check").'</div><div class="column2"><input type="radio" name="paymentMethod" value="Check"></input></div>
        <div class="column2">'.i("PayPal").'</div><div class="column2"><input type="radio" name="paymentMethod" value="PayPal"></input></div>
        <div class="column2">'.i("Other").'</div><div class="column2"><input type="radio" name="paymentMethod" value="Other"></input></div>
        <div class="bottomButton"><input  type="submit" class="button button-primary" value="'.i("Confirm").'"/><input type="reset" class="button button-primary" value="'.i("Reset").'"></div>
        <input class="input1" type="hidden" name="poster" value="paymentMethod"></input>
      </form>';
      $html .= '</div>';




      //a form to submit to myself
      //onclick JS funktion
      $html .= "<div id='giftBox' class=".GrootPaymentView::visibility("giftBox"). ">";
      $html .= '
      <div class="hidden"><input name="giftBox"></input></div> 
      <form action="" method="POST">
      <h1>'.$title4.'</h1><br />
        <h3>'.i("Is it a gift?").'</h3>
        <div class="column2">'.i("No").'</div><div class="column2"><input type="radio" name="giftBox" value="No" checked></input></div>
        <div class="column2">'.i("Yes").'</div><div class="column2"><input type="radio" name="giftBox" value="Yes"></input></div>
        <div class="column2">'.i("Bemerkung").':</div><div class="column2"><textarea name="comment" rows="10" cols="80"></textarea></div>
        <div class="bottomButton"><input id="fakeSubmitButton" type="button" onclick="orderConfirmation()" class="button button-primary" value="'.i("Confirm").'"/><input id="realSubmitButton"  type="submit" class="button button-primary hidden" value="'.i("Confirm").'"/><input type="reset" class="button button-primary" value="'.i("Reset").'"></div>
        <input class="input1" type="hidden" name="poster" value="giftBox"></input>
      </form>';
      $html .= '</div>';




      //a form to submit to myself
      $html .= "<div id='orderComplete' class=".GrootPaymentView::visibility("orderComplete"). ">";
      $html .= '
      <div class="hidden"><input name="orderComplete"></input></div> 
      <h1>'.$title5.'</h1><br />
        <h3>'.i("thx_for_order_msg").'</h3>
          '.i("email_send_msg").' '.$email.' <br>

          <a href="index.php?view=home">
                  <input class="button button-primary" type="button" value="'.i('back_to_main').'"></input>
                </a>

        ';

        //if the order is completed and accepted, send an email to the user email with the previous saved content
        if(GrootPaymentView::visibility("orderComplete") != "hidden"){
            $email_adress  = $email; //"marcel.tschanz@bluemail.ch"; 

            $email_title   = i("Order from Groot Shop");

            $emailContent = "";
            $emailContent .= "".i("Order from Groot Shop")." \n";
            $emailContent .= i("order_confirmation_msg")." \n";
            $emailContent .= " \n";
            $emailContent .= $title1." \n";
            $emailContent .= "--------------------------------\n";
            $emailContent .= i('first_name').":  ".$_SESSION['payment_firstname']." \n";
            $emailContent .= i('last_name').":  ".$_SESSION['payment_lastname']." \n";
            $emailContent .= i('streetname').":  ".$_SESSION['payment_street']." \n";
            $emailContent .= i('zip').":  ".$_SESSION['payment_plz']." \n";
            $emailContent .= i('city').":  ".$_SESSION['payment_country']." \n";
            $emailContent .= " \n";
            $emailContent .= $title2.": ".i($_SESSION['payment_shippingMethod'])." \n";
            $emailContent .= $title3.": ".i($_SESSION['payment_paymentMethod'])." \n";
            $emailContent .= $title4.": ".i($_SESSION['payment_giftBox'])." \n";
            $emailContent .= i('Note').":  ".$_SESSION['payment_comment']." \n";
            $emailContent .= "--------------------------------\n";
            $emailContent .= " \n";
            $emailContent .= $title5." \n";

            //shoppingcart content
            $myArray = json_decode ( $_COOKIE ["shoppingCart"] );
            $myCart = new ShoppingCart ( $myArray );
            $cart = $myCart->getCart();
            foreach($cart as $cartIsbn => $cartAmount){
              $list = BookModel::findList(array('isbn' => array($cartIsbn)), null);
              $title = $list[0]['title'];
              $emailContent .= i('title')." ".$title."  ".i('isbn').":  ".$cartIsbn."  ".$cartAmount."x \n";
            }

            $emailContent .= "--------------------------------\n";
            $emailContent .= " \n";
            $emailContent .= " \n";
            $emailContent .= i("greetings_from_groot_team_msg")." \n";


            $email_message = $emailContent;
            //TSCM Bitte beim Testen auskommentiert, weil es jedes mal wieder eine Email an mich versantd hat
            mail($email_adress, $email_title, $email_message); 
        }
      $html .= '</div>';


      //show post values
      $postedValues = "";
      foreach($_POST as $key => $value){
        $postedValues .= "key = $key und value = $value </br>";
      }
      return $html;

    }


    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>