<?php
//author: David Kempf

class System_Installs_InstalldbTest extends PHPUnit_Framework_TestCase
{
	protected $dbType;
	protected $dbHost;
	protected $dbPort;
	protected $dbName;
	protected $dbUser;
	protected $dbPassword;
	
	protected $installScriptPath;

	protected function setUp()
	{
		$this->dbType = 'mysql';
		$this->dbHost = 'localhost';
		$this->dbPort = 3306;
		$this->dbName = 'system_db_test';
		$this->dbUser = 'root';
		$this->dbPassword = '';
		
		$this->installScriptPath = realpath(dirname(__FILE__)) . '/../..';
	}
	
	function testInstalldb()
	{
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
		
		echo PHP_EOL.'..starte die DB-Test-Installation, bitte warten..'.PHP_EOL;
		ob_flush();
		
		try {
			$dbConnection = new PDO($this->dbType.':host='.$this->dbHost.';port='.$this->dbPort.';dbname='.$this->dbName.';charset=UTF8', $this->dbUser, $this->dbPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		} catch(Exception $e) {
			if(1049 == $e->getCode()) {
				$dbConnection = new PDO($this->dbType.':host='.$this->dbHost.';port='.$this->dbPort.';charset=UTF8', $this->dbUser, $this->dbPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				$statement = $dbConnection->prepare('CREATE DATABASE ' . $this->dbName);
				$statement->execute();
				$dbConnection->exec("use " . $this->dbName);
			}
		}
		
		$this->clearTestDatabase();
		
		foreach($dbScriptToExecute as $dbScript) {
			echo PHP_EOL.'installiere Script: "'.$dbScript.'"..';
			ob_flush();
			$this->execSqlScript(file_get_contents($dbScript), $dbConnection);
		}
		
		$this->clearTestDatabase();
		
		echo PHP_EOL.'Test-Installation erfolgreich beendet';
	}
	
	private function clearTestDatabase() {
		$dbConnection = new PDO($this->dbType.':host='.$this->dbHost.';port='.$this->dbPort.';dbname='.$this->dbName.';charset=UTF8', $this->dbUser, $this->dbPassword);
		$this->execSqlScript("SET group_concat_max_len = 10000; SET FOREIGN_KEY_CHECKS = 0; SET @tables = NULL; SELECT GROUP_CONCAT('`', table_schema, '`.`', table_name, '`') INTO @tables FROM information_schema.tables WHERE table_schema = '".$this->dbName."'; SET @tables = CONCAT('DROP TABLE ', @tables); PREPARE stmt FROM @tables; EXECUTE stmt; DEALLOCATE PREPARE stmt; SET FOREIGN_KEY_CHECKS = 1;", $dbConnection);
	}
	
	private function execSqlScript($sql, $dbConnection) {
		$dbConnection->beginTransaction();
		try {
			$statement = $dbConnection->prepare($sql);
			$statement->execute();
			while ($statement->nextRowset()) {/* https://bugs.php.net/bug.php?id=61613 */};
			$dbConnection->commit();
		} catch (PDOException $e) {
			$dbConnection->rollBack();
			$errorInfo = $e->errorInfo;
			echo PHP_EOL.'ERROR WHILE EXECUTING SQL SCRIPT:'.PHP_EOL;
			echo PHP_EOL.'ERROR SQL RETURNCODE: '.$errorInfo[1];
			echo PHP_EOL.'ERROR SQL MESSAGE: '.$errorInfo[2];
			ob_flush();
			exit(1);
		}
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
