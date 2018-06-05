<?php
  // Is localhost method
  function isLocalhost() {
    $whiteList = array('127.0.0.1', '::1');
    if(in_array($_SERVER['REMOTE_ADDR'], $whiteList)) return true;
    return false;
  }

  // Simple page redirect
  function redirect($page) {
    header('location: ' . APP_URL . '/' . $page);
  }
  
  // Flash message helper
  function flash($name = '', $message = '', $class = 'alert alert-success') {
    if(!empty($name)) {
      //No message, create it
      if(!empty($message) && empty($_SESSION[$name])) {
        if(!empty($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        if(!empty($_SESSION[$name . '_class'])) {
            unset($_SESSION[$name . '_class']);
        }
        $_SESSION[$name] = $message;
        $_SESSION[$name.'_class'] = $class;
      }
      //Message exists, display it
      elseif(!empty($_SESSION[$name]) && empty($message)) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'success';
        echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }