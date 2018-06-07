<?php
/*
	PHP ErrorHandler Class
	author: David Kempf
*/

/* error handler settings, put them in your config-file */
define("SYSTEM_DEBUG", "1");
define("SYSTEM_LOG_ERROR", "1");
/* error handler settings, put them in your config-file */

/* include the SimpleLog class to log errors  */
include_once "SimpleLog.php";
/* include the SimpleLog class to log errors  */

class ErrorHandler {
  private static $_debug = SYSTEM_DEBUG;
  private static $_logerrors = SYSTEM_LOG_ERROR;
  private static $_multipleErrors = false;

  // error handle function, called by set_error_handler
  public static function handle_error($num, $str, $file, $line, $context = null) {
    self::handle_exception(new ErrorException($str, 0, $num, $file, $line));
  }

  // handle exception function called by the error handle function
  public static function handle_exception(Exception $e) {
    if(self::$_debug == 1) {
        echo '<body style="background-color:#f8f8f8;">';
        echo '<div style="text-align:center;margin-top:100px;color:#1C5C9C;">';
        echo '<h3>An error has occurred:</h3>';
        echo '<table cellpadding="12" style="display:inline-block;color:#1C5C9C;">';
        echo '<tr style="background-color:rgb(230,230,230);"><th style="width:80px;">Type</th><td>' . get_class($e) . '</td></tr>';
        echo '<tr style="background-color:rgb(240,240,240);"><th>Message</th><td>{' . $e->getMessage() . '}</td></tr>';
        echo '<tr style="background-color:rgb(230,230,230);"><th>File</th><td>{' . $e->getFile() . '}</td></tr>';
        echo '<tr style="background-color:rgb(240,240,240);"><th>Line</th><td>{' . $e->getLine() . '}</td></tr>';
        echo '<tr style="background-color:rgb(240,240,240);"><th>Request-URL</th><td>{' . $_SERVER['REQUEST_URI'] . '}</td></tr>';
        echo '<tr style="background-color:rgb(230,230,230);"><th>Exception</th><td>' . preg_replace("/\n/", '<br>', $e->getTraceAsString()) . '</td></tr>';
        echo '</table>';
        echo '</div>';
        echo '</body>';
        if(!self::$_multipleErrors) {
          exit;
        }
    }
    if(self::$_logerrors == 1) {
      $logType = 'ERROR';
      if('ErrorException' == get_class($e)) {
        switch($e->getSeverity()) {
          case E_ERROR:              $logType = 'ERROR';   break;
          case E_WARNING:            $logType = 'WARNING'; break;
          case E_PARSE:              $logType = 'ERROR';   break;
          case E_NOTICE:             $logType = 'NOTICE';  break;
          case E_CORE_ERROR:         $logType = 'ERROR';   break;
          case E_CORE_WARNING:       $logType = 'WARNING'; break;
          case E_COMPILE_ERROR:      $logType = 'ERROR';   break;
          case E_COMPILE_WARNING:    $logType = 'WARNING'; break;
          case E_USER_ERROR:         $logType = 'ERROR';   break;
          case E_USER_WARNING:       $logType = 'WARNING'; break;
          case E_USER_NOTICE:        $logType = 'NOTICE';  break;
          case E_STRICT:             $logType = 'ERROR';   break;
          case E_RECOVERABLE_ERROR:  $logType = 'ERROR';   break;
          case E_DEPRECATED:         $logType = 'WARNING'; break;
          case E_USER_DEPRECATED:    $logType = 'WARNING'; break;
          default:                   $logType = 'ERROR';
        }
      }
      // log the error message
      SimpleLog::getInstance()->log($e->getMessage() . ' - Exception: ' . $e->getTraceAsString(), $logType, null, true, $e->getFile(), $e->getLine());
    }
    if(!self::isLocalhost()) {
      //header("Location: {errorPage.html}");
    }
    exit;
  }

  // check for fatal function called by register_shutdown_function
  public static function check_for_fatal() {
    $error = error_get_last();
    if($error['type'] == E_ERROR) {
      self::handle_error($error['type'], $error['message'], $error['file'], $error['line']);
    }
  }

  // localhost check helper function
  public static function isLocalhost() {
    $whiteList = array('127.0.0.1','::1');
    if(in_array($_SERVER['REMOTE_ADDR'], $whiteList)) {
      return true;
    }
    return false;
  }
}

/* do not change */
register_shutdown_function('ErrorHandler::check_for_fatal');
set_error_handler('ErrorHandler::handle_error');
set_exception_handler('ErrorHandler::handle_exception');
ini_set('display_errors','off');
error_reporting(E_ALL);
/* do not change */

