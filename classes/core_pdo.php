<?php

/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class core_pdo {

	function __construct($params) {
		$this->params = $params;
		if (empty($this->params['type'])) {
			$this->params['type'] = "mysql";
		}
		$this->connect();
	}

	function connect($connection = 'connection', $params = NULL) {
		/**
		 * This function creates a connection and assigns it to a variable in.
		 * 
		 * @param $connection - This is defaulted to 'connection' but supports anything the user may choose
		 * @param $params - These are the details pertaining to a newly created connection, if not set it uses the config params.
		 */
		if ($params !== null) {
			$this->params = $params;
		}
		$dsn = "{$this->params['type']}:dbname={$this->params['name']};host={$this->params['host']}";
		try {
			$this->$connection = new PDO($dsn, $this->params['user'], $this->params['pass']);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	function execute($array, $stmt = 'stmt', $connection = 'connection') {
		$stmt = 'prepare_'.$stmt;
		$sth = $this->$stmt->execute($array);
		if ($sth instanceof PDOStatement) {
			$this->values = $sth->fetchAll(PDO::FETCH_ASSOC);
		}
		if (preg_match("/insert/i", $sql)) {
			$this->lastid = $this->$connection->lastInsertId();
		}
	}

	function fetch_array($params = false) {
		if (count($this->values) == 0) {
			return false;
		} elseif (count($this->values) > 1) {
			return $this->values;
		} else {
			if ($params == true) {
				return $this->values;
			} elseif ($params['item']) {
				$item = $params['item'];
				if ($this->values[0][$item]) {
					return $this->values[0][$item];
				} elseif ($this->values[$item]) {
					return $this->values[$item];
				} else {
					return false;
				}
			} else {
				return $this->values[0];
			}
		}
	}
	
	function insert_id() {
		return $this->lastid;
	}

	function num_rows() {
		return count($this->values);
	}
	
	function prepare($sql, $stmt = 'stmt', $connection = 'connection') {
		$stmt = 'prepare_'.$stmt;
		$this->$stmt = $this->$connection->prepare($sql);
	}

	function query($sql, $params = NULL, $connection = 'connection') {
		$sth = NULL;
		$this->values = NULL;
		$this->lastid = NULL;
		if ($sql == '') {
			return false;
		}
		if ($params === NULL) {
			try {
				$this->error = NULL;
				$sth = $this->$connection->query($sql);
			} catch(PDOException $e) {
				$this->error = $e->getMessage();
			}
		} else {
			$sth = $this->$connection->prepare($sql);
			
			try {
				$this->error = NULL;
				$sth->execute($params);
			} catch(PDOException $e) {
				$this->error = $e->getMessage();
			}
		}
		if ($sth instanceof PDOStatement) {
			$this->values = $sth->fetchAll(PDO::FETCH_ASSOC);
		}
		if (preg_match("/insert/i", $sql)) {
			$this->lastid = $this->$connection->lastInsertId();
		}
		
		return $this;
	}

}
