<?php
  class GrootHeaderViewlet implements IViewlet {

    public static function name() {
      return 'header';
    }

    public function process($config) {
      // Here comes the processing of the field-parameters
    }

    public function render() {
      // Here comes the rendering process
      return '<div id="logo">
        <span class="stdanimation1_4">G</span>
      </div>
      <form id="search">
        <select name="category">
          <option value="1">Fantasy</option>
          <option value="2">Horror</option>
          <option value="3">Mein kleiner Scheich</option>
        </select>
        <input type="text" name="search_text" id="search_text" />
        <button type="submit" name="search" value="search">Suchen</button>
      </form>
      <ul class="menu menu-main">
        <li><a class="stdanimation1_2">Kategorien</a></li>
        <li><a class="stdanimation1_2">Profil</a></li>
        <li><a class="stdanimation1_2">Wunschzettel</a></li>
        <li><a class="stdanimation1_2">Warenkorb</a></li>
      </ul>';
    }

    public function ajaxCall() {

    }

  }
?>