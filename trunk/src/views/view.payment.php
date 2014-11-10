<?php
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
//var_dump("poster is = $poster");

        switch($function){

          case "deliveryAddress":
            if($poster == 'none'){
              $result = "";
            }else{
              $result =  $class;
            }
          break;

          case "shippingMethod":
          
 // var_dump($function);
  //var_dump($poster);
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

      

      //Test to include JAVASCRIPT


      $js = '

';



      //add Product to session
      //Only if its not jet there
      if($_SESSION['shoppingCart']['id'] && $_GET['id']){
        if(!in_array($_GET['id'],$_SESSION['shoppingCart']['id'])){
          $_SESSION['shoppingCart']['id'][] = $_GET['id'];
        }
      };
// var_dump($_SESSION['shoppingCart']['id']);

      //create shopping cart id list
      $htmlList = "Sie haben folgende Produkte gekauft:</br>";
      foreach($_SESSION['shoppingCart']['id'] as $isbn_number){

        $htmlList .= "ISBN NUMBER = $isbn_number </br>";
      }
//unset($_SESSION['shoppingCart']['id']);
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

      

      //a form to submit to myself
      $html .= "<div id='deliveryAddress' class=".GrootPaymentView::visibility("deliveryAddress"). ">";
      $html .= '
      <div class="hidden"><input name="deliveryAddressStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title1.'</h1><br />
        <div class="column1">First Name</div><div class=""><input class="input1 " name="firstname"></input></div><br />
        <div class="column1">Last Name</div><div class=""><input class="input1" name="lastname"></input></div><br />
        <div class="column1">Street</div><div class=""><input class="input1" name="street"></input></div><br />
        <div class="column1">PLZ</div><div class=""><input class="input1" name="plz"></input></div><br />
        <div class="column1">Country</div><div class=""><input class="input1" name="country"></input></div><br />
        <input type="submit" class="buy_button" value="Send"/><input type="reset" class="buy_button" value="Reset">
        <input class="input1" type="hidden" name="poster" value="deliveryAddress"></input>
      </form>';
      $html .= '</div>';



      //a form to submit to myself
//  var_dump(GrootPaymentView::visibility("shippingMethod"));
      $html .= "<div id='shippingMethod' class=".GrootPaymentView::visibility("shippingMethod").">";
      $html .= '
      <div class="hidden"><input name="shippingMethodStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title2.'</h1><br />
        <div class="column2">Home delivery</div><div class="column2"><input type="radio" name="shippingMethod" value="Home delivery" checked></input></div>
        <div class="column2" >Nearest Store</div><div class="column2"><input type="radio" name="shippingMethod" value="Nearest Store"></input></div>
        <div class="column2">Other</div><div class="column2"><input type="radio" name="shippingMethod" value="Other"></input></div>
        <div class="bottomButton"><input  type="submit" class="buy_button" value="Send"/><input type="reset" class="buy_button" value="Reset"></div>
        <input class="input1" type="hidden" name="poster" value="shippingMethod"></input>
      </form>';
      $html .= '</div>';


//var_dump(GrootPaymentView::visibility("paymentMethod"));
      //a form to submit to myself
      $html .= "<div id='paymentMethod' class=".GrootPaymentView::visibility("paymentMethod"). ">";
      $html .= '
      <div class="hidden"><input name="paymentMethodStore"></input></div> 
      <form action="" method="POST">
      <h1>'.$title3.'</h1><br />
        <div class="column2">Visa</div><div class="column2"><input type="radio" name="paymentMethod" value="Visa" checked></input></div>
        <div class="column2">Postfinance</div><div class="column2"><input type="radio" name="paymentMethod" value="Postfinance"></input></div>
        <div class="column2">Maestro</div><div class="column2"><input type="radio" name="paymentMethod" value="Maestro"></input></div>
        <div class="column2">Check</div><div class="column2"><input type="radio" name="paymentMethod" value="Check"></input></div>
        <div class="column2">PayPal</div><div class="column2"><input type="radio" name="paymentMethod" value="PayPal"></input></div>
        <div class="column2">Other</div><div class="column2"><input type="radio" name="paymentMethod" value="Other"></input></div>
        <div class="bottomButton"><input  type="submit" class="buy_button" value="Send"/><input type="reset" class="buy_button" value="Reset"></div>
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
        <h3>Is a Gift?</h3>
        <div class="column2">NO</div><div class="column2"><input type="radio" name="giftBox" value="No" checked></input></div>
        <div class="column2">Yes</div><div class="column2"><input type="radio" name="giftBox" value="Yes"></input></div>
        <div class="column2">Bemerkung:</div><div class="column2"><textarea name="comment" rows="10" cols="80">Here goes your text...</textarea></div>
        <div class="bottomButton"><input id="fakeSubmitButton" type="button" onclick="orderConfirmation()" class="buy_button" value="Send fake"/><input id="realSubmitButton"  type="submit" class="buy_button" value="Send"/><input type="reset" class="buy_button" value="Reset"></div>
        <input class="input1" type="hidden" name="poster" value="giftBox"></input>
      </form>';
      $html .= '</div>';




      //a form to submit to myself
      $html .= "<div id='orderComplete' class=".GrootPaymentView::visibility("orderComplete"). ">";
      $html .= '
      <div class="hidden"><input name="orderComplete"></input></div> 
      <h1>'.$title5.'</h1><br />
        <h3>Besten Dank für die Bestellung!</h3>
          Es wurde eine Email mit der Bestellung an Sie versand!
          An matscha7@gmail.com:



        ';
        if(GrootPaymentView::visibility("orderComplete") != "hidden"){
            //$email_adress  = "matscha7@gmail.com";
            $email_adress  = "marcel.tschanz@bluemail.ch"; 
            $email_title   = "Bestellung auf Groot Shop"; 
            $email_message = $htmlList; 
            //TSCM auskommentiert, da lästig, weil es jedes mal wieder eine Email versandt hat.
            //mail($email_adress, $email_title, $email_message); 
        }
      $html .= '</div>';


      //show post values
      $postedValues = "";
      foreach($_POST as $key => $value){
        $postedValues .= "key = $key und value = $value </br>";
      }
      $html .= '
          <div>
            The posted Values are: </br>
            '.$postedValues.'
         </div>
         ';
      return $html;

    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>