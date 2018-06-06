<?php
/* 
 PDO DATABASE CLASS
 Connects Database Using PDO
 Creates Prepeared Statements
 Binds params to values
 Returns rows and results
*/

/* db settings, put them in your config-file */
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "test");
/* db settings, put them in your config-file */
   
class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	private $dbh;
	private $error;
	private $stmt;
	
	public function __construct() {
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array (
			// set PDO::ATTR_PERSISTENT = true if you want a persistent connection
			PDO::ATTR_PERSISTENT => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);
		try {
			// connect to database
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}	catch(PDOException $e) {
			$this->error = $e->getMessage();
		}
	}
	
	// check if a connection error exists
	public function hasError() {
		return $this->error != null;
	}
	
	// get the connection error
	public function getError() {
		return $this->error;
	}
	
	// prepare the query
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	// bind values
	public function bind($param, $value, $type = null) {
		if(is_null($type)) {
			switch(true) {
				case is_int($value) :
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value) :
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value) :
					$type = PDO::PARAM_NULL;
					break;
				default :
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	
	// execute
	public function execute() {
		return $this->stmt->execute();
	}
	
	// get data as array of objects
	public function fetchAll() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	// get row as object
	public function fetch() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}
	
	// get the results count
	public function count() {
		return $this->stmt->rowCount();
	}
	
	// get last insert id
	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}
	
	// execute sql with prepare, bind and execute
	public function executeSql($sql, $data = []) {
		$this->query($sql);
		foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
		if($this->execute()) return true;
		return false;
	}

	// insert data with prepare, bind and execute
	public function insertInto($sql, $data = []) {
		return $this->executeSql('INSERT INTO ' . $sql, $data);
	}

	// update data with prepare, bind and execute
	public function update($sql, $data = []) {
		return $this->executeSql('UPDATE ' . $sql, $data);
	}

	// delete data with prepare, bind and execute
	public function deleteFrom($sql, $data = []) {
		return $this->executeSql('DELETE FROM ' . $sql, $data);
	}

	// select data with prepare, bind and fetchAll
	public function select($sql, $data = []) {
		$this->query('SELECT ' . $sql);
		foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
		return $this->fetchAll();
	}

	// select row with prepare, bind and fetch
	public function selectOne($sql, $data = []) {
		$this->query('SELECT ' . $sql);
		foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
		return $this->fetch();
	}
}