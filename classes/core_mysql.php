<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class core_mysql
{	
	public $core;
	var $q_from = '';
	var $q_insert = array();
	var $q_into = array();
	var $q_join = array();
	var $q_orderby = array();
	var $q_order = '';
	var $q_select = array();	
	var $q_where = array();
	var $q_where_or = array();
	var $q_values = array();
	var	$result = null;
	
	function __construct($params)
	{
		$this->params = $params;
		$this->connect();
	}
	
	function clear()
	{
		$this->q_from = array();
		$this->q_insert = array();
		$this->q_into = array();
		$this->q_join = array();
		$this->q_orderby = array();
		$this->q_order = '';
		$this->q_select = array();	
		$this->q_where = array();
		$this->q_where_or = array();
		$this->q_values = array();
	}
	
	function connect($connection='connection',$params=null)
	{
		/**
		 * This function creates a connection and assigns it to a variable in.
		 * 
		 * @param $connection - This is defaulted to 'connection' but supports anything the user may choose
		 * @param $params - These are the details pertaining to a newly created connection, if not set it uses the config params.
		 */
		
		if ($params !== null)
		{
			$this->params = $params;
		}
		if ($this->params['port'] != '')
		{
			$this->params['host'] .= ':'.$this->params['port'];
		}
		$this->$connection = mysql_connect($this->params['host'],$this->params['user'],$this->params['pass'], TRUE);
		if (isset($this->params['name']))
		{
			mysql_select_db($this->params['name'], $this->$connection);
		}
	}
	
	function fetch_array()
	{
		$resulting = false;
		if (mysql_num_rows($this->result) > 1) 
		{
			while ($row = @mysql_fetch_array($this->result,MYSQL_ASSOC))
			{
				$resulting[] = $row;
			}
		}
		else
		{
			$resulting = @mysql_fetch_array($this->result,MYSQL_ASSOC);
		}
		return $resulting;
	}
	
	function from($from = null)
	{
		$this->q_from = $this->clean_array($from, true);
		return $this;
	}
	
	function get($variable = '', $connection='connection')
	{
		$this->result = null;
		if (count($this->q_select) > 0)
		{
			if (count($this->q_select) > 1) $query = "SELECT ".implode(', ',$this->q_select);
			else $query = "SELECT ".$this->q_select;
			if ($this->q_from != '')
			{
				$query .= " FROM ".$this->q_from;
			}
			if (count($this->q_join) > 0)
			{
				$query .= " ".implode(', ',$this->q_join);
			}
			if (count($this->q_where) > 0)
			{
				$query .= " WHERE ".implode(' AND ',$this->q_where);
			}
			if (count($this->q_where_or) > 0)
			{
				$query .= " WHERE ".implode(' OR ',$this->q_where_or);
			}
			if (count($this->q_orderby) > 0)
			{
				$query .= " ORDER BY ".implode(', '.$this->q_orderby)." ".strtoupper($this->q_order);
			}
		}
		elseif (count($this->q_insert) > 0)
		{
			$query = "INSERT INTO ".implode(', ', $this->q_into)."(".implode(', ', $this->q_insert).") VALUES(".implode(', '.$this->q_values).")";
		}
		$this->result = mysql_query($query,$this->$connection);		
		$this->clear();
		return $this;
	}
	
	function insert($table, $array)
	{
		$this->q_into = merge_array($this->q_into,$this->clean_array($table));
		$array = $this->clean_array($array);
		foreach ($array as $key => $value)
		{
			$this->q_insert[] = $key;
			$this->q_values[] = "'".$value."'";
		}
		return $this;
	}
	
	function join($join_on, $type = 'INNER')
	{
		$join_on = $this->clean_array($join_on);
		$join_types = array('INNER', 'OUTER', 'LEFT', 'RIGHT');
		if (! in_array($type, $join_types)) $type = 'INNER';
		foreach ($join_on as $k => $v)
		{
			$this->q_join[] = $type." JOIN ".$k." ON ".$v;
		}
		return $this;
	}
	
	function num_rows()
	{
		if ($this->result)
		{
			return mysql_num_rows($this->result);
		}
	}
	
	function orderby($order_by, $type='ASC')
	{
		$this->q_orderby = $this->clean_array($order_by);
		$this->q_orderpath = $this->clean_array($type,true);
	}
	
	function query($sql, $connection='connection')
	{
		if ($sql == '')
		{
			return false;
		}
		$this->result = mysql_query($sql,$this->$connection);
		return $this;
	}
	
	function row()
	{
		return mysql_fetch_array($this->result);
	}
	
	function select($select = '*')
	{
		if (count($this->q_select) > 0) $this->q_select = array_merge($this->q_select, $this->clean_array($select));
		else $this->q_select = $this->clean_array($select, true);
		return $this;
	}
	
	function where($where=null, $type='AND')
	{
		$where_value = $this->clean_array($where);
		if ($type == 'AND' || $type == 'OR')
		{
			foreach ($where_value as $k => $l)
			{
				$array = $k;
				if (! preg_match('/ /', $k)) $array .= " =";
				$where_array[] = $array." '".$l."'";
			}
		}
		if ($type == 'AND')
		{
			$this->q_where = array_merge($this->q_where, $where_array);
		}
		elseif ($type == 'OR')
		{
			$this->q_where_or = array_merge($this->q_where_or, $where_array);
		}
		return $this;
	}
	
	function clean_array($array, $string=false)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $value)
			{
				$key = mysql_real_escape_string($key);
				$array_val[$key] = mysql_real_escape_string($value);
			}
		}
		else
		{
			if ($string == false)
			{
				$array_val[] = mysql_real_escape_string($array);
			}
			else
			{
				$array_val = mysql_real_escape_string($array);
			}
		}
		return $array_val;
	}
}