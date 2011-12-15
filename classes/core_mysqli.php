<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class core_mysqli
{
	function __construct($params)
	{
		$this->params = $params;
		$this->connect();
	}
}
