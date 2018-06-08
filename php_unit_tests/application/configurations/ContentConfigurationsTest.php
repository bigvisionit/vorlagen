<?php
/*
	PHP ContentConfigurationsTest, Configurations with Language Content
	author: David Kempf
*/
class System_ContentConfigurations_ContentConfigurationsTest extends PHPUnit_Framework_TestCase
{
	protected $installScriptPath;
	
	// sets the root path
	protected function setUp()
	{
		$this->installScriptPath = realpath(dirname(__FILE__)) . '/../..';
	}
	
	// test function to run: calls getMissedConfigurations() and checks if there are more than '0'
	function testConfigurations()
	{
		$missedConfigurations = $this->getMissedConfigurations();
    	$this->assertTrue(0 == count($missedConfigurations), '[ERROR] Es existieren keine Script-Eintraege fuer die folgenden Content-Configurations:'.PHP_EOL.implode(PHP_EOL, $missedConfigurations));
	}
	
	// get missed configurations function: gets all db scripts and checks if there are missed scripts
	private function getMissedConfigurations() {
		$connection = Doctrine_Manager::getInstance()->getCurrentConnection();
		$sql = 'SELECT * FROM contentconfiguration';
		$stmnt = $connection->execute($sql);
		$configurations = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		$missedConfigurations = array();
		$scripts = $this->getAllDBScripts();
		foreach($configurations as $key => $configuration) {
			$configurations[$key]['added'] = false;
			foreach($scripts as $script) {
				$scriptContent = explode("\n", file_get_contents($script));
				foreach($scriptContent as $contentLine) {
					if(false !== strpos($contentLine, $configuration['ConfigKey'])) {
					   $configurations[$key]['added'] = true;
					   break;
					}
				}
				if($configurations[$key]['added']) break;
			}
			if(!$configurations[$key]['added']) {
				array_push($missedConfigurations, $configuration['ConfigKey']);
			}
		}
		return $missedConfigurations;
	}
	
	// get all db scripts function called in getMissedConfigurations()
	private function getAllDBScripts() {
		$dbInstallFiles = scandir($this->installScriptPath . '/../db/install/');
		usort($dbInstallFiles, 'version_compare');
		
		$sizeInstallFiles = count($dbInstallFiles);
		
		$installFile = $dbInstallFiles[($sizeInstallFiles-1)];
		if($installFile == '..' || $installFile == '.') {
			throw new Exception('Could not find database installation files.');
		}
		
		$installFileVersion = str_replace('.sql', '', $installFile);
		
		$dbScriptFolders = array();
		$dbScriptFilesTmp = scandir($this->installScriptPath . '/../db/scripts/');
		foreach($dbScriptFilesTmp as $scriptFileTmp) {
			if($scriptFileTmp != '.' && $scriptFileTmp != '..' && $scriptFileTmp != 'archive') {
				if(version_compare($scriptFileTmp, $installFileVersion) > 0) {
					$dbScriptFolders[] = $scriptFileTmp;
				}
			}
		}
		
		usort($dbScriptFolders, 'version_compare');
		
		$dbScripts = array();
		
		foreach($dbScriptFolders as $dbScriptFolder) {
			$tmpFiles = scandir($this->installScriptPath . '/../db/scripts/'.$dbScriptFolder.'/');
			sort($tmpFiles);
		
			foreach($tmpFiles as $tmpFile) {
				if($tmpFile != '..' && $tmpFile != '.') {
					$dbScripts[$dbScriptFolder][] = $tmpFile;
				}
			}
		}
		
		$existingData = $this->findExistingInstallation();
		$existing = $existingData['existing'];
		$configData = null;
		if($existing) {
			$configData = $existingData['configData'];
		}
		
		$dbInstallFiles = scandir($this->installScriptPath . '/../db/install/');
		usort($dbInstallFiles, 'version_compare');
		
		$sizeInstallFiles = count($dbInstallFiles);
		
		$installFile = $dbInstallFiles[($sizeInstallFiles-1)];
		if($installFile == '..' || $installFile == '.') {
			throw new Exception('Could not find database installation files.');
		}
		
		$installFileVersion = str_replace('.sql', '', $installFile);
		
		$RELEASE_VERSION = $configData['version'];
		$RELEASE_VERSION_SCRIPT = end($dbScripts[$configData['version']]);
		
		$dbScriptFolders = array();
		$dbScriptFilesTmp = scandir($this->installScriptPath . '/../db/scripts/');
		foreach($dbScriptFilesTmp as $scriptFileTmp) {
			if($scriptFileTmp != '.' && $scriptFileTmp != '..' && $scriptFileTmp != 'archive') {
				if(version_compare($scriptFileTmp, $RELEASE_VERSION) < 1 && version_compare($scriptFileTmp, $installFileVersion) > 0) {
					$dbScriptFolders[] = $scriptFileTmp;
				}
			}
		}
		
		usort($dbScriptFolders, 'version_compare');
		
		$dbScriptToExecute = array();
		$dbScriptToExecute[] = $this->installScriptPath . '/../db/install/'.$installFile;
		
		foreach($dbScriptFolders as $dbScriptFolder) {
			$tmpFiles = scandir($this->installScriptPath . '/../db/scripts/'.$dbScriptFolder.'/');
			sort($tmpFiles);
		
			foreach($tmpFiles as $tmpFile) {
				if($tmpFile != '..' && $tmpFile != '.') {
					$dbScriptToExecute[] = $this->installScriptPath . '/../db/scripts/'.$dbScriptFolder.'/'.$tmpFile;
				}
					
				if($dbScriptFolder === end($dbScriptFolders) && $RELEASE_VERSION_SCRIPT == $tmpFile) break;
			}
		}
		return $dbScriptToExecute;
	}
	
	// find existing installation function to get the config, called in getAllDBScripts()
	private function findExistingInstallation() {
		if(file_exists($this->installScriptPath . '/../application/configs/system.ini')
			&& file_exists($this->installScriptPath . '/../application/configs/system.ini')
			&& file_exists($this->installScriptPath . '/../library/Zend/Config/Ini.php') ) {

			set_include_path(implode(PATH_SEPARATOR, array(
					realpath($this->installScriptPath . '/../library'),
					get_include_path()
			)));

			require_once $this->installScriptPath . '/../library/Zend/Config/Ini.php';

			$configSystem = new Zend_Config_Ini($this->installScriptPath . '/../application/configs/system.ini', 'production');
			$configSystem = new Zend_Config_Ini($this->installScriptPath . '/../application/configs/system.ini', 'production');

			$existingVersion = $configSystem->system->version;

			$result = array();

			$result['existing'] = true;

			$configData = array();
			$configData['version'] = $existingVersion;

			$configData['db.type'] = $configSystem->system->db->type;
			$configData['db.user'] = $configSystem->system->db->user;
			$configData['db.password'] = $configSystem->system->db->password;
			$configData['db.host'] = $configSystem->system->db->host;
			$configData['db.port'] = $configSystem->system->db->port;
			$configData['db.name'] = $configSystem->system->db->name;

			$result['configData'] = $configData;

			return $result;
		} else {
			$result = array();
			$result['existing'] = false;
			return $result;
		}
	}
}
