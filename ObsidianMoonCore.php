<?php

/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class ObsidianMoonCore 
{

	public $output;
	public $systime;
	public $is_ajax;
	public $error;
	public $conf_libs;
	public $conf_core;
	public $conf_base;
	public $conf_publ;
	
	public function __construct() {
		$this->systime = time();
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->is_ajax = true;
		}		
	}
	
	public function classes() {
		
	}
	
	public function views() {
		
	}
}
