<?php
	/* 
   *  PDO DATABASE CLASS
   *  Connects Database Using PDO
	 *  Creates Prepeared Statements
	 * 	Binds params to values
	 *  Returns rows and results
   */
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
			PDO::ATTR_PERSISTENT => false,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
		);
		try {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}	catch(PDOException $e) {
			$this->error = $e->getMessage();
		}
	}
	
	public function query($query) {
		$this->stmt = $this->dbh->prepare($query);
	}
	
	public function bind($param, $value, $type = null) {
		if(is_null($type)) {
			switch (true) {
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
	
	public function execute() {
		return $this->stmt->execute();
	}
	
	public function fetchAll() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}
	
	public function fetch() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}
	
	public function count() {
		return $this->stmt->rowCount();
	}
	
	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}
	
	public function executeSql($sql, $data = []) {
		$this->query($sql);
		foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
		if($this->execute()) return true;
		return false;
	}

	public function insertInto($sql, $data = []) {
		return $this->executeSql('INSERT INTO ' . $sql, $data);
	}

	public function update($sql, $data = []) {
		return $this->executeSql('UPDATE ' . $sql, $data);
	}

	public function deleteFrom($sql, $data = []) {
		return $this->executeSql('DELETE FROM ' . $sql, $data);
	}

	public function select($sql, $data = []) {
		$this->query('SELECT ' . $sql);
    foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
    return $this->fetchAll();
	}

	public function selectOne($sql, $data = []) {
		$this->query('SELECT ' . $sql);
    foreach($data as $name => $value) {
			$this->bind(':' . $name, $value);
		}
    return $this->fetch();
	}
}