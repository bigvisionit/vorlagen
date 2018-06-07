<?php
  /* 
   *  APP CORE CLASS
   *  Creates URL & Loads Core Controller
   *  URL Format - /controller/method/param1/param2
   */
  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
      $url = $this->getUrl();
      /* '-' separating by capital letters for controller names */
      if(strpos($url[0], '-') !== false) {
        $urlArr = array_map('ucfirst', explode('-', $url[0]));
        $urlArr[0] = strtolower($urlArr[0]);
        $url[0] = implode('', $urlArr);
      }
      if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
        $this->currentController = ucwords($url[0]);
        unset($url[0]);
      }
      require_once('../app/controllers/' . $this->currentController . '.php');
      $this->currentController = new $this->currentController;
      if(isset($url[1])) {
      /* '-' separating by capital letters for function names */
      if(strpos($url[1], '-') !== false) {
        $urlArr = array_map('ucfirst', explode('-', $url[1]));
        $urlArr[1] = strtolower($urlArr[1]);
        $url[1] = implode('', $urlArr);
      }
      if(method_exists($this->currentController, $url[1])) {
          $this->currentMethod = $url[1];
          unset($url[1]);
        }
      }
      $this->params = $url? array_values($url) : [];
      call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
      if(isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  }