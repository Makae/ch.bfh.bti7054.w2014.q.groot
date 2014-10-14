<?php
  class GrootNaviViewlet implements IViewlet {

    public static function name() {
      return 'navi';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      return '<div id="sub-menu">
          <ul class="menu">
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_house_alt"></span>
              <a class="stdanimation1_4" href="index.html">Home</a>
            </li>
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_profile"></span>
              <a class="stdanimation1_4" href="profil.html">Profil</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_tag"></span>
              <a class="stdanimation1_4">Kategorien</a>
            </li>
            <li class="stdanimation">
              <span class="stdanimation1_2 icon_cart"></span>
              <a class="stdanimation1_4" href="shoppingcart.html" >Shopping Cart</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_gift"></span>
              <a class="stdanimation1_4">Ipsum</a>
            </li>
            <li class="stdanimation1_4">
              <span class="stdanimation1_4 icon_grid-2x2"></span>
              <a class="stdanimation1_4">Doloret</a>
            </li>
          </ul>
        </div>';
    }

    public function ajaxCall() {

    }

  }
?>