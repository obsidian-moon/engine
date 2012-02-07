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
		if (isset($conf['modules'])) {
			if (is_array($conf['modules'])) {
				$exception = NULL;
				foreach ($conf['modules'] as $key => $value) {
					try {
						if (is_numeric($key)):
							$this->classes($value);
						else:
							$this->classes($key,$value);
						endif;
					} catch(Exception $e) {
						$exception .= $e->getMessage()."<br />\n";
					}
				}
				if ($exception !== NULL) {
					throw new Exception($exception);
				}
			} else {
				try {
					if (is_numeric($key)):
						$this->classes($value);
					else:
						$this->classes($key,$value);
					endif;
				} catch(Exception $e) {
					throw new Exception($e->getMessage());
				}
			}	
		}
	}
	
	public function classes($key, $value=NULL) {
		
	}
	
	public function views() {
		
	}
}
