<?php
//author: David Kempf

class System_Versions_VersionsTest extends PHPUnit_Framework_TestCase
{
	protected $installScriptPath;
	
	protected function setUp()
	{
		$this->installScriptPath = realpath(dirname(__FILE__)) . '/../..';
	}
	
	function testVersions()
	{
		$configSystem = new Zend_Config_Ini($this->installScriptPath . '/../application/configs/system.ini', 'production');
		$systemVersion = $configSystem->system->version;
		$this->assertTrue($systemVersion == $this->getDBVersion(), '[ERROR] System- und Datenbank-Versionen sind verschieden.'.PHP_EOL);
	}
	
	private function getDBVersion() {
		$connection = Doctrine_Manager::getInstance()->getCurrentConnection();
		$sql = "SELECT Value FROM configuration WHERE ConfigKey = 'system.db.version'";
		$stmnt = $connection->execute($sql);
		return $stmnt->fetchAll(PDO::FETCH_COLUMN)[0];
	}
}
