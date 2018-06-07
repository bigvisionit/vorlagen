<?php
/*
	PHP SimpleLog Class
	author: David Kempf
*/
class SimpleLog {
    protected static $_instance = null;
    private $_error = false;
    private $_file = 'logs/_log.txt';
    private $_deleteOlderLogFiles = true;
    private $_deleteAfterDays = 14;
    private $_logByDays = true;
    private $_logIP = true;
    const INFO    = 'INFO';
    const WARNING = 'WARNING';
    const NOTICE  = 'NOTICE';
    const ERROR   = 'ERROR';
    const DEBUG   = 'DEBUG';
    const OTHER   = 'OTHER';
    const UNKNOWN = 'UNKNOWN';

    /**
     * Gets an instance of the SimpleLog.
     * @return SimpleLog
    */
    public static function getInstance() {
        if(null === self::$_instance)
            self::$_instance = new SimpleLog();
        return self::$_instance;
    }

    public function __construct($file = null) {
        $this->_file = dirname(__FILE__) . '/' . $this->_file;
        if(null != $file) {
            $this->_file = $file;
        }
        $dirName = dirname($this->_file);
        $fileName = basename($this->_file);
        //Create every Day a new log file
        if($this->_logByDays) {
            $newName = $dirName . '/' . date('Y-m-d') . $fileName;
            $this->_file = $newName;
        }
        //If the log file becomes too large (over 1MB), archive it and create a new one.
        if(file_exists($this->_file) && ((filesize($this->_file) / 1024) > 1024)) {
            $newName = $dirName . '/' . date('Y-m-d') . '_archive_' . $this->getUniqueID() . '_' . $fileName;
            if(!rename($this->_file, $newName)) {
                $this->_error = 'Can\'t rename the old log file';
            }
            //delete logs older than '$deleteAfterDays' days
            if($this->_deleteOlderLogFiles) {
                foreach(glob($dirName . '/*.log') as $logFile) {
                    if(filemtime($logFile) < (time() - ($this->_deleteAfterDays * 24 * 3600))) {
                        unlink($logFile);
                    }
                }
            }
            file_put_contents($this->_file, '');
        } elseif(!file_exists($this->_file)) {
            file_put_contents($this->_file, '');
        }
    }

    // write log message
    public function write($message) {
        $message = preg_replace('/\s+/', ' ', trim($message)) . PHP_EOL;
        if(!file_put_contents($this->_file, $message, FILE_APPEND)) {
            $this->_error = 'Can\'t write to log';
        }
    }

    // log function with time logging, needs to call endLog afterwards
    public function startLog() {
        $msgStart = 'Start time: ' . date('Y-m-d - h:i:s') . PHP_EOL;
        if(!file_put_contents($this->_file, $msgStart, FILE_APPEND)) {
            $this->_error = 'Can\'t write to log';
        }
    }

    // log function with time logging, needs to call startLog before
    public function endLog() {
        $msgEnd = 'End time: ' . date('Y-m-d - h:i:s') . PHP_EOL;
        $msgEnd .= '-------------------------------' . PHP_EOL;
        if(!file_put_contents($this->_file, $msgEnd, FILE_APPEND)) {
            $this->_error = 'Can\'t write to log';
        }
    }

    // error log function for ErrorHandler class
    public function log($message, $messageType = self::INFO, $uniqueID = null, $showClientInfo = true, $file = null, $line = null) {
        $debugBacktrace = debug_backtrace();
        $codeInfo = (isset($debugBacktrace[1]['file']) && isset($debugBacktrace[1]['line']))? ' - on line: ' . $debugBacktrace[1]['line'] . ', in file: "' . $debugBacktrace[1]['file'] . '" ' : '';
        $codeInfo = (null != $file && null != $line)? ' - on line: ' . $line . ', in file: "' . $file . '"' : $codeInfo;
        $message = preg_replace('/\s+/', ' ', trim($message));
        $uniqueID = (null != $uniqueID)? '[' . $uniqueID . ']' : '[' . $this->getUniqueID() . ']';
        $clientInfo = ($showClientInfo)? self::getClientUserData($this->_logIP) : '';
        $message = (($this->_logByDays)? date('h:i:s') : date('Y-m-d - h:i:s')) . ' [' . $messageType . ']' . $uniqueID . ': ' . $message . $codeInfo . ', request-url: "' . $_SERVER['REQUEST_URI'] . '" ' . $clientInfo;
        $this->write($message);
    }

    // log exception function, logs Error Stacktrace
    public function logException($e) {
        $this->log($e->getTraceAsString(), self::ERROR);
    }

    // generates an unique id to identify logging entries
    public function getUniqueID() {
        return uniqid();
    }

    // return if an error is occured (logfile cannot be written or something)
    public function isError() {
        if(false != $this->_error) {
            return true;
        }
        return false;
    }

    // get the error (logfile cannot be written or something)
    public function getError() {
        return $this->_error;
    }

    // get the setting if the ip is logged
    public function getLogIP() {
        return $this->_logIP;
    }

    // get client ip for getClientUserData function
    public static function getClientIP() {
        $ipAddress = 'Unknown';
        if(isset($_SERVER['HTTP_CLIENT_IP'])) {
          $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
          $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
          $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_FORWARDED'])) {
          $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if(isset($_SERVER['REMOTE_ADDR'])) {
          $ipAddress = $_SERVER['REMOTE_ADDR'];
        }
        return $ipAddress;
      }
    
      // get client browser for getClientUserData function
      public static function getClientBrowser() {
        $u_agent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
        $b_name = 'Unknown';
        $ub = 'Unknown';
        $platform = 'Unknown';
        $version = '';
        $pattern = '';
        if(preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
        } elseif(preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
        } elseif(preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
        }
        if(preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
          $b_name = 'Internet Explorer';
          $ub = 'MSIE';
        } elseif(preg_match('/Firefox/i', $u_agent)) {
          $b_name = 'Mozilla Firefox';
          $ub = 'Firefox';
        } elseif(preg_match('/Chrome/i', $u_agent)) {
          $b_name = 'Google Chrome';
          $ub = 'Chrome';
        } elseif(preg_match('/Safari/i', $u_agent)) {
          $b_name = 'Apple Safari';
          $ub = 'Safari';
        } elseif(preg_match('/Opera/i', $u_agent)) {
          $b_name = 'Opera';
          $ub = 'Opera';
        } elseif(preg_match('/Netscape/i', $u_agent)) {
          $b_name = 'Netscape';
          $ub = 'Netscape';
        }
        if($ub == 'Unknown') {
          return array(
            'userAgent' => $u_agent,
            'name'      => $b_name,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'   => $pattern
          );
        }
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        $i = count($matches['browser']);
        if($i != 1) {
          if(strripos($u_agent, 'Version') < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
          } else {
            $version = $matches['version'][1];
          }
        } else {
          $version = $matches['version'][0];
        }
        if(null == $version || '' == $version) {
          $version = '?';
        }
        return array(
          'userAgent' => $u_agent,
          'name'      => $b_name,
          'version'   => $version,
          'platform'  => $platform,
          'pattern'   => $pattern
        );
      }
    
      // getClientUserData function called in log function
      public static function getClientUserData($ip = true) {
        return '-- browser: ' . self::getClientBrowser()['name'] . ' (version: ' . self::getClientBrowser()['version'].'), platform: ' . ucfirst(self::getClientBrowser()['platform']) . (($ip)? ', ip: ' . self::getClientIP() . ' --' : ' --');
      }
}
