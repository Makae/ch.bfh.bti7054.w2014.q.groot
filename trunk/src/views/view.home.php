<?php
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
      return ' <h1>Suche</h1>
          <div class="product">
            <div class="img-preview"><img  src="images/test_medizin.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=123123">Titel: TDYSDF</a></p>
              <p>Autor: Herbert Janson</p>
              <p class="description-text">Beschreibung: Lasdfa dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 19.95 </p>
              <p>Lieferbar: Sofort</p>
            </div>
          </div>
          <div class="product">
            <div class="img-preview"><img  src="images/chemibuch.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=523123">Titel: Fizz  peng</a></p>
              <p>Autor: Herbert Janson</p>
              <p class="description-text">Beschreibung: werwerpsum dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 44.55 </p>
              <p>Lieferbar: Sofort</p>
            </div>
          </div>
          <div class="product">
            <div class="img-preview"><img  src="images/sport.jpg"  />

            </div>
            <div class="description">
              <p><a href="product.html?id=123423">Titel: Sport ist Mord</a></p>
              <p>Autor: Simon Phelps</p>
              <p class="description-text">Beschreibung: Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel purus eget nisl efficitur iaculis.
              Praesent eleifend mauris et nunc suscipit sagittis. Donec suscipit nisi id
              quam rhoncus interdum. Donec eu egestas tortor, ac finibus nunc. Interdum
              et malesuada fames ac ante ipsum primis in faucibus. Pellentesque porta,
              faucibus mattis malesuada sit amet tellus. Ut ac pretium nisl.
              Nam maximus lobortis sem, et aliquet nisi imperdiet vel. Suspendisse
              potenti. Nam consectetur lobortis est, in faucibus mi egestas non.</p>

              <p>Preis: CHF 22.15 </p>
              <p>Lieferbar: Vergriffen</p>
            </div>
          </div>';
    }

    public function ajaxCall() {
      // we will return the value as json encoded content
      return json_encode('asdf');
    }

  }
?>