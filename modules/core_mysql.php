<?php

/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class core_mysql {

	public $core;
	var $result = null;
	var $error = null;

	function __construct($params) {
		trigger_error('Use core_pdo instead of core_mysql', E_USER_DEPRECATED);
		$this->params = $params;
		$this->connect();
	}

	function connect($connection = 'connection', $params = null) {
		/**
		 * This function creates a connection and assigns it to a variable in.
		 * 
		 * @param $connection - This is defaulted to 'connection' but supports anything the user may choose
		 * @param $params - These are the details pertaining to a newly created connection, if not set it uses the config params.
		 */
		if ($params !== null) {
			$this->params = $params;
		}
		if ($this->params['port'] != '') {
			$this->params['host'] .= ':' . $this->params['port'];
		}
		$this->$connection = mysql_connect($this->params['host'], $this->params['user'], $this->params['pass'], TRUE);
		if (isset($this->params['name'])) {
			mysql_select_db($this->params['name'], $this->$connection);
		}
	}

	function error($connection = 'connection') {
		if (!isset($this->error)) {
			$this->error = mysql_error($this->$connection);
		}
		return $this->error;
	}

	function execute($array, $stmt = 'stmt', $connection = 'connection') {
		$stmt = 'prepare_'.$stmt;
		$sql = $this->$stmt;
		foreach ($array as $value) {
			$replacement = "'".mysql_real_escape_string($value)."'";
			$sql = preg_replace('/\?/i',$replacement,$sql,1);
		}
		if (!($this->result = mysql_query($sql, $this->$connection))) {
			$this->error = $sql." : ".mysql_error($this->$connection);
		}
		if (preg_match("/insert/i", $sql)) {
			$this->lastid = $this->$connection->mysql_insert_id();
		}
	}
	
	function fetch_array($params = false) {
		$resulting = false;
		if (mysql_num_rows($this->result) > 0) {
			if (mysql_num_rows($this->result) > 1) {
				while ($row = @mysql_fetch_array($this->result, MYSQL_ASSOC)) {
					$resulting[] = $row;
				}
			} else {
				if ($params === true) {
					$resulting[] = @mysql_fetch_array($this->result, MYSQL_ASSOC);
				} elseif ($params['item']) {
					$item = $params['item'];
					$return = @mysql_fetch_array($this->result, MYSQL_ASSOC);
					$resulting = $return[$item];
				} else {
					$resulting = @mysql_fetch_array($this->result, MYSQL_ASSOC);
				}
			}
		}
		return $resulting;
	}
	
	function insert_id() {
		return $this->lastid;
	}

	function num_rows() {
		if ($this->result) {
			return mysql_num_rows($this->result);
		}
	}

	function prepare($sql, $stmt = 'stmt', $connection = 'connection') {
		$stmt = 'prepare_'.$stmt;
		$this->$stmt = $sql;
	}
	
	function query($sql, $params = NULL, $connection = 'connection') {
		if ($sql == '') {
			return false;
		}
		if ($params !== NULL) {
			foreach ($params as $value) {
				$replacement = "'".mysql_real_escape_string($value)."'";
				$sql = preg_replace('/\?/i',$replacement,$sql,1);
			}
		}
		if (!($this->result = mysql_query($sql, $this->$connection))) {
			$this->error = $sql." : ".mysql_error($this->$connection);
		}
		if (preg_match("/insert/i", $sql)) {
			$this->lastid = $this->$connection->mysql_insert_id();
		}
		return $this;
	}

	function row() {
		return mysql_fetch_array($this->result);
	}

	function clean_array($array, $string = false) {
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$key = mysql_real_escape_string($key);
				$array_val[$key] = mysql_real_escape_string($value);
			}
		} else {
			if ($string == false) {
				$array_val[] = mysql_real_escape_string($array);
			} else {
				$array_val = mysql_real_escape_string($array);
			}
		}
		return $array_val;
	}

}