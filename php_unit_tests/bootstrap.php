<?php
define('APPLICATION_ENV', 'testing');
define('APPLICATION_UNIT_TESTING', true);
require_once dirname(__FILE__) . '/init.php';

$application = Application::bootstrap();