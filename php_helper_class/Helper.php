<?php
/*
	PHP Simple Helper Class with usefull functions
	author: David Kempf
*/
class Helper {
	
	// Simple send mail helper function with some security check
    public static function sendMail($message, $subject, $from, $to, $cc = '', $html = false) {
		// remove line breaks from input and prevent also to append more recievers
		if(preg_match('/[\r\n]/', $from) || preg_match('/[\r\n]/', $to) || preg_match('/[\r\n]/', $cc)) {
			return;
		}
		$from = filter_var($from, FILTER_SANITIZE_EMAIL);
		$to = filter_var($to, FILTER_SANITIZE_EMAIL);
		if($html) {
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: <' . $from . '>' . "\r\n";
		} else {
			$headers = 'From: <' . $from . '>' . "\r\n";
		}
		if($cc != '') {
			$cc = filter_var($cc, FILTER_SANITIZE_EMAIL);
			$headers .= 'Cc: ' . $cc . "\r\n";
		}
		return mail($to, $subject, $message, $headers);
	}
	
	// Simple log text to file function, can be a string or an array of lines
	public static function logText($text, $file, $logDate = false, $separator = PHP_EOL) {
		if(is_array($text)) {
			$text = implode($separator, $text);
		}
		if($logDate) {
			$content = date('Y-m-d H:i:s') . ': ' . $text . $separator;
		} else {
			$content = $text . $separator;
		}
		if($separator != PHP_EOL) {
			$content = rtrim($content, $separator);
		}
		$file = fopen(__DIR__ . '/' . $file, 'a');
		fwrite($file, $content);
		fclose($file);
	}
	
	// Simple text read from file function, returns a string or an array of lines
	public static function readText($file, $perLine = false, $separator = PHP_EOL) {
		$file = new SplFileObject(__DIR__ . '/' . $file);
		if($perLine) {
			$lines = [];
			while(!$file->eof()) {
				$lines[] = rtrim($file->fgets());
			}
		} else {
			$lines = '';
			if($separator != PHP_EOL) {
				while(!$file->eof()) {
					$lines .= rtrim($file->fgets()) . $separator;
				}
				$lines = rtrim($lines, $separator);
			} else {
				while(!$file->eof()) {
					$lines .= $file->fgets();
				}
			}
		}
		$file = null;
		return $lines;
	}
	
	// Simple CSV read from file function, returns an array of lines
	public static function readCSV($file) {
		$file = fopen(__DIR__ . '/' . $file, 'r');
		$lines = [];
		while($line = fgetcsv($file)) {
			$lines[] = [ $line[0], $line[1] ];
		}
		fclose($file);
		return $lines;
	}
	
	// Simple file to string function
	public static function include2String($file, array $vars = array()) {
		extract($vars);
		ob_start();
		$file = __DIR__ . '/' . $file;
		include($file);
		return ob_get_clean();
	}
	
	// Resample image function, creates and returns the new image
	public static function resampleImage($file, $newFile, $width, $height = 'auto', $quality = 90) {
		$file = __DIR__ . '/' . $file;
		$newFile = __DIR__ . '/' . $newFile;
		if(!file_exists($newFile)) {
			list($w, $h) = getimagesize($file);
			$ratio = $width / $w;
			if($height == 'auto') {
				$height = round($ratio * $h);
			}
			$img = imagecreatefromjpeg($file);
			$imgResample = imagecreatetruecolor($width, $height);
			imagecopyresampled($imgResample, $img, 0, 0, 0, 0, $width, $height, $w, $h);
			imagejpeg($imgResample, $newFile, $quality);
		}
		header('Content-Type: image/jpeg');
		readfile($newFile);
	}
	
	// Simple function to test for localhost
	public static function isLocalhost() {
		$whiteList = array('127.0.0.1', '::1');
		if(in_array($_SERVER['REMOTE_ADDR'], $whiteList)) return true;
		return false;
	}
	
	// Starts with string function
	public static function startsWith($str, $startStr) {
		return 0 === strpos($str, $startStr);
	}
	
	// Ends with string function
	public static function endsWith($str,$endStr) {
		return mb_strlen($str) - mb_strlen($endStr) === strrpos($str, $endStr);
	}	
	
	// Print_r with pre output function
	public static function print_r_pre($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	// Var_dump with pre output function
	public static function var_dump_pre($var) {
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}
	
	// Simple get function
	public static function get($name, $trim = false) {
		if(isset($_GET[$name])) return (($trim)? trim($_GET[$name]) : $_GET[$name]);
		return null;
	}
	
	// Simple post function
	public static function post($name, $trim = false) {
		if(isset($_POST[$name])) return (($trim)? trim($_POST[$name]) : $_POST[$name]);
		return null;
	}
	
	// Simple request function
	public static function request($name, $trim = false) {
		if(isset($_REQUEST[$name])) return (($trim)? trim($_REQUEST[$name]) : $_REQUEST[$name]);
		return null;
	}
	
	// Simple server function
	public static function server($name) {
		if(isset($_SERVER[$name])) return $_SERVER[$name];
		return null;
	}
	
	// Simple session function
	public static function session($name, $value = null) {
		if(!isset($_SESSION))return null;
		if(is_null($value)) {
			if(isset($_SESSION[$name])) return $_SESSION[$name];
		} else $_SESSION[$name]=$value;
		return null;
	}
	
	// Simple unset session function
	public static function unsetSession($name) {
		unset($_SESSION[$name]);
	}
	
	// Check for post function
	public static function isPost() {
		return (self::server('REQUEST_METHOD') == 'POST');
	}
	
	// Check for ajax function
	public static function isAjax() {
		return (null != self::server('HTTP_X_REQUESTED_WITH')) AND strtolower(self::server('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
	}
	
	// Is null or empty function
	public static function isNullOrEmpty($variable) {
		return(null === $variable || '' === $variable);
	}
	
	// Is integer function
	public static function isInteger($value, $positive = true) {
		return ((filter_var($value, FILTER_VALIDATE_INT) !== false) && ($positive? (int)$value >= 0 : true));
	}
	
	// Returns a random alphanumeric string
	public static function randomString($size = '5') {
		$string = '';
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		for($i = 0; $i < $size; $i++)
			$string .= $characters[mt_rand(0, (strlen($characters) - 1))];
		return $string;
	}
	
	// Get the page url
	public static function getPageUrl($params = false) {
		return ((strpos(strtolower(self::server('SERVER_PROTOCOL')), 'https') === FALSE)? 'http' : 'https').
			'://' . self::server('HTTP_HOST') . self::server('SCRIPT_NAME') . (($params)? '?' . self::server('QUERY_STRING') : '');
	}
	
	// Get the client ip
	public static function getClientIP() {
		$ipAddress = '';
		if(null != self::server('HTTP_CLIENT_IP')) {
			$ipAddress = self::server('HTTP_CLIENT_IP');
		} else if(null != self::server('HTTP_X_FORWARDED_FOR')) {
			$ipAddress = self::server('HTTP_X_FORWARDED_FOR');
		} else if(null != self::server('HTTP_X_FORWARDED')) {
			$ipAddress = self::server('HTTP_X_FORWARDED');
		} else if(null != self::server('HTTP_FORWARDED_FOR')) {
			$ipAddress = self::server('HTTP_FORWARDED_FOR');
		} else if(null != self::server('HTTP_FORWARDED')) {
			$ipAddress = self::server('HTTP_FORWARDED');
		} else if(null != self::server('REMOTE_ADDR')) {
			$ipAddress = self::server('REMOTE_ADDR');
		} else {
			$ipAddress = 'UNKNOWN';
		}
		return $ipAddress;
	}
	
	// Get client browser function
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

	// Get client user data function
	public static function getClientUserData($ip = true) {
		return '-- browser: ' . self::getClientBrowser()['name'] . ' (version: ' . self::getClientBrowser()['version'].'), platform: ' . ucfirst(self::getClientBrowser()['platform']) . (($ip)? ', ip: ' . self::getClientIP() . ' --' : ' --');
	}

	// Get german holidays as array
	public static function getHolidays($fromNow = true) {
		$easter_d = date('d', easter_date(date('Y')));
		$easter_m = date('m', easter_date(date('Y')));
		$holidays = [
			date('Y') . '-01-01' => 'Neujahr',
			date('Y-m-d', mktime(0, 0, 0, $easter_m, $easter_d - 2, date('Y'))) => 'Karfreitag',
			date('Y') . '-' . $easter_m . '-' . $easter_d => 'Ostersonntag',
			date('Y-m-d', mktime(0, 0, 0, $easter_m, $easter_d + 1, date('Y'))) => 'Ostermontag',
			date('Y') . '-05-01' => 'Erster Mai',
			date('Y-m-d', mktime(0, 0, 0, $easter_m, $easter_d + 39, date('Y'))) => 'Christi Himmelfahrt',
			date('Y-m-d', mktime(0, 0, 0, $easter_m, $easter_d + 49, date('Y'))) => 'Pfingstsonntag',
			date('Y-m-d', mktime(0, 0, 0, $easter_m, $easter_d + 50,date('Y'))) => 'Pfingstmontag',
			date('Y') . '-10-03' => 'Tag der deutschen Einheit',
			date('Y') . '-12-24' => 'Heiliger Abend',
			date('Y') . '-12-25' => '1. Weihnachtsfeiertag',
			date('Y') . '-12-26' => '2. Weihnachtsfeiertag',
			date('Y') . '-12-31' => 'Silvester'
		];
		if($fromNow) {
			foreach($holidays as $date=>$holidayName) {
				if($date < date('Y-m-d')) {
					unset($holidays[$date]);
				}
			}
		}
		return $holidays;
	}

	// Check for german holidays from date
	public static function isHoliday($date, $fromNow = true) {
		return array_key_exists($date, getHolidays($fromNow));
	}
}
