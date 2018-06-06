<?php
  /* 
   *  CORE CONTROLLER CLASS
   *  Loads Models & Views
   */
  class Controller {
		public function __construct() {
			$this->translations = parse_ini_file('../app/languages/' . $_SESSION['language'] . '.ini');
		}

		public function translate($key, $replaceWith = null) {
			$translation = $this->translations[$key];
			if(null !== $replaceWith) {
					if(is_array($replaceWith)) {
							for($i = 1; $i <= count($replaceWith); $i++) {
									$translation = str_replace('$' . $i, $replaceWith[$i - 1], $translation);
							}
					} else {
						$translation = str_replace('$1', $replaceWith, $translation);
					}
			}
			return $translation;
		}

    public function model($model) {
      require_once '../app/models/' . $model . '.php';
      return new $model();
    }
	
		public function view($data = [], $settings = [], $url = null) {
			if(is_null($url)) {
				$url = strtolower(debug_backtrace()[1]['class']) . '/' . debug_backtrace()[1]['function'];
			}
			if((!isset($settings['header']) || $settings['header']) &&
			(!isset($settings['ajax']) || !$settings['ajax'])) {
				require_once '../app/views/skins/' . APP_SKIN . '/inc/header.php';
			}
			/* capital letters separating by '-' for view file names */
			if(preg_match('/[A-Z]/', $url) != 0) {
				$urlArr = preg_split('/(?=[A-Z])/', $url, -1, PREG_SPLIT_NO_EMPTY);
				$urlArr = array_map('strtolower', $urlArr);
				$url = implode('-', $urlArr);
			}
			if(file_exists('../app/views/skins/' . APP_SKIN . '/' . $url . '.php')) {
				require_once '../app/views/skins/' . APP_SKIN . '/' . $url . '.php';
			}
			if((!isset($settings['footer']) || $settings['footer']) &&
			(!isset($settings['ajax']) || !$settings['ajax'])) {
				require_once '../app/views/skins/' . APP_SKIN . '/inc/footer.php';
			}
		}
  }