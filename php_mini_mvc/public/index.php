<?php
  require_once '../app/bootstrap.php';

  function index() {
    echo 'start';
  }

  function test($test) {
    view([ 'test' => $test ]);
  }