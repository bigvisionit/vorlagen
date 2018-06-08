<?php
/*
	PHP ModelsTest
	author: David Kempf
*/
class System_Models_ModelsTest extends PHPUnit_Framework_TestCase
{

	protected $modelsPath;
	protected $modelsTestPath;
	protected $application;

	// sets the root path to models and a path to temp models for the test,
	// initialize Doctrine
	protected function setUp()
	{
		$this->modelsPath = APPLICATION_PATH . '/../application/models';
		$this->modelsTestPath = APPLICATION_PATH . '/../data/tmp/models';
		
		global $application;
		$this->application = $application;
		
		$config = $this->application->getOption('doctrine');
		$config['generateTableClasses'] = true;
		$cli = new Doctrine_Cli($config);

		Doctrine::generateModelsFromDb($this->modelsTestPath, array('doctrine'), $config);
	}
	
	// test function to run: calls files_are_equal() and delete_files(), checks if the generated Doctrine models are different from existing models
	function testModels()
	{
		$availableModels = array();
		$modelFiles = scandir($this->modelsPath . '/generated');
		
		foreach($modelFiles as $modelFile) {
			if($modelFile != '.' && $modelFile != '..') {
				$availableModels[] = $modelFile;
			}
		}
		
		$availableTestModels = array();
		$modelTestFiles = scandir($this->modelsTestPath . '/generated');
		
		foreach($modelTestFiles as $modelTestFile) {
			if($modelTestFile != '.' && $modelTestFile != '..') {
				$availableTestModels[] = $modelTestFile;
			}
		}
		
		$filesNotEqualError = false;
		foreach($availableModels as $availableModel) {
			if(!in_array($availableModel, $availableTestModels)) {
				echo PHP_EOL.'[ERROR] Die Datei '.$availableModel. ' ist unbekannt';
				$filesNotEqualError = true;
			}
		}
		
		$this->assertTrue(false == $filesNotEqualError, '[ERROR] Die Anzahl der generierten Models stimmt nicht ueberein.'.PHP_EOL.'Loesung: Inhalt in "system/application/models/generated" leeren, "generatemodels.php" aufrufen und erneut ausfuehren!'.PHP_EOL);
		
		foreach($availableTestModels as $availableTestModel) {
			if(!in_array($availableTestModel, $availableModels)) {
				echo PHP_EOL.'[ERROR] Die Datei '.$availableTestModel. ' existiert nicht';
				$filesNotEqualError = true;
			}
		}
		
		$this->assertTrue(false == $filesNotEqualError, '[ERROR] Die Anzahl der generierten Models stimmt nicht ueberein.'.PHP_EOL.'Loesung: "generatemodels.php" aufrufen und erneut ausfuehren!'.PHP_EOL);
		
		foreach($availableModels as $availableModel) {
			$this->assertTrue(
				$this->files_are_equal($this->modelsPath . '/generated/' . $availableModel, $this->modelsTestPath . '/generated/' . $availableModel), 
				'[ERROR] Die Tabelle "'.str_replace('.php', '', str_replace('Base', '', $availableModel)).'" stimmt nicht mit dem generierten Model ueberein'.PHP_EOL.'Loesung: "generatemodels.php" aufrufen und erneut ausfuehren!'.PHP_EOL
			);
		}
		
		$this->delete_files($this->modelsTestPath);
	}
	
	// files equal function: called in testModels()
	private function files_are_equal($a, $b)
	{
		$s1 = explode("\n", file_get_contents($a));
		$s2 = explode("\n", file_get_contents($b));
		
		$d = array_diff($s1, $s2);
		if(0 < count($d)) {
			echo PHP_EOL.'[ERROR] Zeilen: '.PHP_EOL.implode(PHP_EOL, $d);
		}
		
		return 0 == count($d);
	}
	
	// delete files function to delete the models test path installation: called in testModels()
	private function delete_files($path)
	{
		$files = glob($path . '/*');
		foreach($files as $file) {
			is_dir($file)? $this->delete_files($file) : unlink($file);
		}
		
		rmdir($path);
		return;
	}
}
