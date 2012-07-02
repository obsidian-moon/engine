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
		$dsn = "mysql:dbname={$this->params['name']};host={$this->params['host']}";
		try {
			$this->$connection = new PDO($dsn, $this->params['user'], $this->params['pass']);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
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
				return $this->values[0][$item];
			} else {
				return $this->values[0];
			}
		}
	}

	function num_rows() {
		return count($this->values);
	}

	function query($sql, $params = NULL, $connection = 'connection') {
		$sth = null;
		if ($sql == '') {
			return false;
		}
		if ($params === NULL) {
			$sth = $this->$connection->query($sql);
		} else {
			$sth = $this->$connection->prepare($sql);
			$sth->execute($params);
		}
		if ($sth instanceof PDOStatement) {
			$this->values = $sth->fetchAll(PDO::FETCH_ASSOC);
		}
		
		return $this;
	}

}
