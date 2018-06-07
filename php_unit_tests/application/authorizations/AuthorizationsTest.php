<?php
//author: David Kempf

class Authorizations_AuthorizationsTest extends PHPUnit_Framework_TestCase
{
	protected $installScriptPath;
	
	protected function setUp()
	{
		$this->installScriptPath = realpath(dirname(__FILE__)) . '/../..';
	}
	
	function testAuthorizations()
	{
		$missedAuthorizations = $this->getMissedAuthorizations();
    	$this->assertTrue(0 == count($missedAuthorizations), '[ERROR] Es existieren keine Script-Eintraege fuer die folgenden Authorizations:'.PHP_EOL.implode(PHP_EOL, $missedAuthorizations));
	}
	
	private function getMissedAuthorizations() {
		$connection = Doctrine_Manager::getInstance()->getCurrentConnection();
		$sql = 'SELECT * FROM authorization';
		$stmnt = $connection->execute($sql);
		$authorizations = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		$missedAuthorizations = array();
		$scripts = $this->getAllDBScripts();
		foreach($authorizations as $key => $authorization) {
			$authorizations[$key]['added'] = false;
			foreach($scripts as $script) {
				$scriptContent = explode("\n", file_get_contents($script));
				foreach($scriptContent as $contentLine) {
					if(false !== strpos($contentLine, $authorization['Key'])) {
					   $authorizations[$key]['added'] = true;
					   break;
					}
				}
				if($authorizations[$key]['added']) break;
			}
			if(!$authorizations[$key]['added']) {
				array_push($missedAuthorizations, $authorization['Key']);
			}
		}
		return $missedAuthorizations;
	}
	
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
