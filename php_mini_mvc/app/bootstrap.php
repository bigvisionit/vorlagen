<?php
session_start();
require_once 'config/config.php';
spl_autoload_register(function($className) {
  require_once 'libraries/'. $className . '.php';
});

/* bootsrap */
bootstrap();
/* bootsrap */

/* getUrl function */
function getUrl() {
  if(isset($_GET['url'])) {
    $url = rtrim($_GET['url'], '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);
    return $url;
  }
}
/* getUrl function */

/* bootsrap function */
function bootstrap() {
  $url = getUrl();
  $currentFunction = ($url[0] == '')? 'index' : $url[0];
  $params = [];
  /* '-' separating by capital letters for function names */
  if(strpos($url[0], '-') !== false) {
    $urlArr = array_map('ucfirst', explode('-', $url[0]));
    $urlArr[0] = strtolower($urlArr[0]);
    $url[0] = implode('', $urlArr);
  }
  if(function_exists($url[0])) {
    $currentFunction = $url[0];
    unset($url[0]);
  } else if($url[0] != '') die('bad request');
  $params = $url? array_values($url) : [];
  call_user_func_array($currentFunction, $params);
}
/* bootsrap function */

/* view function */
function view($data = [], $settings = [], $url = null) {
  if(is_null($url)) {
    $url = debug_backtrace()[1]['function'];
  }
  if((!isset($settings['header']) || $settings['header']) &&
     (!isset($settings['ajax']) || !$settings['ajax'])) {
      require_once 'views/inc/header.php';
  }
  /* capital letters separating by '-' for view file names */
  if(preg_match('/[A-Z]/', $url) != 0) {
    $urlArr = preg_split('/(?=[A-Z])/', $url, -1, PREG_SPLIT_NO_EMPTY);
    $urlArr = array_map('strtolower', $urlArr);
    $url = implode('-', $urlArr);
  }
  if(file_exists('../app/views/' . $url . '.php')) {
    require_once 'views/' . $url . '.php';
  }
  if((!isset($settings['footer']) || $settings['footer']) &&
     (!isset($settings['ajax']) || !$settings['ajax'])) {
    require_once 'views/inc/footer.php';
  }
}
/* view function */