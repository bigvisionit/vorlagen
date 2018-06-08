<?php
/*
	PHP LanguagesTest
	author: David Kempf
*/
class System_Languages_LanguagesTest extends PHPUnit_Framework_TestCase
{

	protected $languagesPath;

	// sets the root path
	protected function setUp()
	{
		$this->languagesPath = APPLICATION_PATH . '/../application/languages';
	}

	// read per line function to get rows from file
	private function readFilePerLine($iniFilePath) {
		$iniFile = file($iniFilePath);
		$configKeys = array();
		$lines = array();
		$duplicates = array();
		foreach($iniFile as $line) {
			$addKey = true;
			if($line[0] == ";") { 
				$lines[] = ';comment';
				$addKey = false; 
			}
			if($line[0] == "[") { 
				$lines[] = $line;
				$addKey = false; 
			}
			if(trim($line) == "") { 
				$lines[] = "";
				$addKey = false; 
			}
			
			if($addKey) {
				$entry = explode("=", $line, 2);
				$ck = trim($entry[0]);
				$configKeys[$ck] = trim($entry[1]);
				$lines[] = $ck;
				
				if(isset($duplicates[$ck])) {
					$duplicates[$ck] = $duplicates[$ck] + 1;
				} else {
					$duplicates[$ck] = 1;
				}
			}
			
		}
		return array('keys' => $configKeys, 'lines' => $lines, 'duplicates' => $duplicates);
	}
	
	// test function to run: calls readFilePerLine() and checks if all language keys are existing in all language files,
	// checks also for positions and duplicate entries
	function testLanguageFiles()
	{
		$availableLanguages = array();
		$langFolders = scandir($this->languagesPath);
		
		foreach($langFolders as $langFolder) {
			if($langFolder != '.' && $langFolder != '..') {
				$availableLanguages[] = $langFolder;
			}
		}
		
		$this->assertTrue(count($availableLanguages) == 3);
		
		$parseResults = array();
		
		foreach($availableLanguages as $lang) {
			$parseResults[$lang] = $this->readFilePerLine($this->languagesPath . '/'.$lang.'/messages_'.$lang.'.ini');
		}
		
		$this->assertTrue(count($parseResults) == 3);
		$this->assertTrue(isset($parseResults['de']));
		$this->assertTrue(isset($parseResults['en']));
		$this->assertTrue(isset($parseResults['fr']));
		
		$deResults = $parseResults['de'];
		$enResults = $parseResults['en'];
		$frResults = $parseResults['fr'];
		
		foreach($deResults['keys'] as $var => $val ) {
			if(isset($enResults['keys'][$var])) {

			} else {
				echo PHP_EOL.'[ERROR] Der Key '.$var. " (de) existiert nicht in messages_en.ini";
			}
		}
		
		foreach($deResults['keys'] as $var => $val ) {
			if(isset($frResults['keys'][$var])) {
		
			} else {
				echo PHP_EOL.'[ERROR] Der Key '.$var. " (de) existiert nicht in messages_fr.ini";
			}
		}
		
		foreach($enResults['keys'] as $var => $val ) {
			if(isset($deResults['keys'][$var])) {
		
			} else {
				echo PHP_EOL.'[ERROR] Der Key '.$var. " (en) existiert nicht in messages_de.ini";
			}
		}
		
		foreach($frResults['keys'] as $var => $val ) {
			if(isset($deResults['keys'][$var])) {
		
			} else {
				echo PHP_EOL.'[ERROR] Der Key '.$var. " (fr) existiert nicht in messages_de.ini";
			}
		}
		
		$duplicateResultDe = array();
		foreach($deResults['duplicates'] as $dupKey => $dupVal) {
			if($dupVal > 1) {
				$duplicateResultDe[] = $dupKey;
			}
		}
		
		$this->assertTrue(count($duplicateResultDe) < 1, '[ERROR] messages_de.ini enthält für folgende Keys Duplikate: ' . implode(', ', $duplicateResultDe));
		
		$duplicateResultEn = array();
		foreach($enResults['duplicates'] as $dupKey => $dupVal) {
			if($dupVal > 1) {
				$duplicateResultEn[] = $dupKey;
			}
		}
		
		$this->assertTrue(count($duplicateResultEn) < 1, '[ERROR] messages_en.ini enthält für folgende Keys Duplikate: ' . implode(', ', $duplicateResultEn));
		
		$duplicateResultFr = array();
		foreach($frResults['duplicates'] as $dupKey => $dupVal) {
			if($dupVal > 1) {
				$duplicateResultFr[] = $dupKey;
			}
		}
		
		$this->assertTrue(count($duplicateResultFr) < 1, '[ERROR] messages_fr.ini enthält für folgende Keys Duplikate: ' . implode(', ', $duplicateResultFr));
		
		
		
		for($i = 0; $i < count($deResults['lines']); $i++) {
			$this->assertEquals($deResults['lines'][$i], $enResults['lines'][$i], '[ERROR] Die messages_de.ini und messages_en.ini unterscheiden sich in Zeile: '. ($i+1));
			$this->assertEquals($deResults['lines'][$i], $frResults['lines'][$i], '[ERROR] Die messages_de.ini und messages_fr.ini unterscheiden sich in Zeile: '. ($i+1));
		}
		
		$this->assertEquals(count($deResults['keys']), count($enResults['keys']), '[ERROR] Language Files (de,en) beinhaltet nicht die gleiche Anzahl an Keys.');
		$this->assertEquals(count($deResults['lines']), count($enResults['lines']), '[ERROR] Language Files (de,en) beinhaltet nicht die gleiche Anzahl an Zeilen.');
		
		$this->assertEquals(count($deResults['keys']), count($frResults['keys']), '[ERROR] Language Files (de,fr) beinhaltet nicht die gleiche Anzahl an Keys.');
		$this->assertEquals(count($deResults['lines']), count($frResults['lines']), '[ERROR] Language Files (de,fr) beinhaltet nicht die gleiche Anzahl an Zeilen.');
	}

}
