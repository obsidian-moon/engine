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
	
	public function __construct($conf = null) {
		$this->systime = time();
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$this->is_ajax = true;
		}
		// Assign all configuration values to $conf_**** variables
		if (isset($conf) && is_array($conf)) {
			foreach ($conf as $key => $value) {
				$var = 'conf_'.$key;
				$this->$var = $value;
			}
		}
	}
	
	public function classes() {
		
	}
	
	public function views() {
		
	}
}
