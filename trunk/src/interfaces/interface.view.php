<?php
  interface IView {
    function name();
    function viewletMainMenu();
    function viewletSubMenu();
    function viewletFooter();
    function process();
    function render();
    function ajaxCall();
  }
?>