<?php
  session_start();

  // Load Config
  require_once 'config/config' . (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])? '.dev' : '') . '.php';
  
  // Set Language
  if(!isset($_SESSION['language'])) {
    $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if(in_array($language, ['de-at', 'de-ch'])) {
      $language = 'de';
    }
    if(!in_array($language, ['de', 'en'])) {
      $language = 'en';
    }
    $_SESSION['language'] = $language;
  }

  // Load Helpers
  $helperFiles = glob(APP_ROOT . '/helpers/*.php');
  foreach($helperFiles as $helperFile) {
    require_once $helperFile;
  }
  
  // Autoload Core Classes
  spl_autoload_register(function ($className) {
      require_once 'libraries/'. $className . '.php';
  });
