<?php

  class Core {
    private $view = array();

    public function __construct() {
      $files = glob('class.*.php');
      echo "<pre>";
      die(var_dump($files));
    }

  }


?>