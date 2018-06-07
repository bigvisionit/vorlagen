<?php
//author: David Kempf

class System_Routes_RoutesTest extends PHPUnit_Framework_TestCase
{
	protected $bootsrapFile;
	
	protected function setUp()
	{
		$this->bootsrapFile = APPLICATION_PATH . '/../application/Bootstrap.php';
	}
	
	function testRoutes()
	{
		$bootstrapContent = explode("\n", file_get_contents($this->bootsrapFile));
		$routeNames = array();
		foreach($bootstrapContent as $contentLine) {
			preg_match('/addRoute\((.*?),/', $contentLine, $match);
			if(0 < count($match)) {
				array_push($routeNames, $match[1]);
			}
		}
		$duplicateRouteNames = array_unique(array_diff_assoc($routeNames, array_unique($routeNames)));
		
		$this->assertTrue(0 == count($duplicateRouteNames), '[ERROR] Es existieren folgende doppelte Routennamen:'.PHP_EOL.implode(PHP_EOL, $duplicateRouteNames));
	}
}
