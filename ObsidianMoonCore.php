<?php

/**
 * 
 * Obsidian Moon Engine presented by Dark Prospect Games
 * @author Rev. Alfonso E Martinez, III
 * @copyright (c) 2011
 * 
 */
class ObsidianMoonCore {

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
				$var = 'conf_' . $key;
				$this->$var = $value;
			}
		}
		if (isset($conf['modules'])) {
			if (is_array($conf['modules'])) {
				$exception = NULL;
				try {
					$this->classes($conf['modules']);
				} catch (Exception $e) {
					throw new Exception($exception);
				}
			} else {
				try {
					if (is_numeric($key)):
						$this->classes($value);
					else:
						$this->classes($key, $value);
					endif;
				} catch (Exception $e) {
					throw new Exception($e->getMessage());
				}
			}
		}
	}

	function classes($modules, $alternate_name = "", $p3_mname = null) {
		trigger_error("classes() method is deprecated, please module() method instead.",E_USER_DEPRECATED);
		$this->module($modules,$alternate_name,$p3_mname);
	}

	function module($modules, $alternate_name = "", $p3_mname = null) {
		/**
		 * This function will load classes as needed for the user to use.
		 * It will allow them to be accessible via $core->modulename.
		 * 
		 * @param $modules - This is the file and class name of the class being called.
		 * @param $alternate_name - This is what the user would like to name the variable if available.
		 */
		if (!is_array($modules)) {
			$modules = array($modules, array($alternate_name, $p3_mname));
		}
		foreach ($modules as $module => $alternate_name) {
			if (is_array($alternate_name))
				list($alternate_name, $p3_mname) = $alternate_name;
			if (is_numeric($module))
				$module = $alternate_name;
			if (preg_match('/\//', $module)) {
				$module_name = end(explode('/', $module));
			} elseif ($p3_mname !== null) {
				$module_name = $p3_mname;
			} else {
				$module_name = $module;
			}

			if (preg_match('/^core\//', $module))
				$modules_location = $this->conf_core . 'modules/' . $module_name . '.php';
			elseif (preg_match('/^third_party\//', $module))
				$modules_location = $this->conf_libs . $module . '.php';
			else
				$modules_location = $this->conf_libs . 'modules/' . $module . '.php';
			$configs_location = $this->conf_libs . 'modules/' . $module . '.php';
			if (file_exists($modules_location)) {
				include($modules_location);
				if (class_exists($module_name)) {
					if (file_exists($configs_location)) {
						include($configs_location);
					}
					if ($alternate_name == "") {
						$alternate_name = $module_name;
					}
					if (!isset($this->$alternate_name)) {
						if (isset($config) && $config !== null) {
							$this->$alternate_name = new $module_name($this, $config);
						} else {
							$this->$alternate_name = new $module_name($this);
						}
						if (method_exists($this->$alternate_name, 'om_start')) {
							$this->$alternate_name->om_start();
						}
					} else {
						throw new Exception("Variable '\$this->$alternate_name' has already been set, could not instantiate module '$module_name'!");
					}
				} else {
					throw new Exception("Module '$module_name' does not exist, please check the location and try again!");
				}
			}
		}
		return true;
	}

	function view($_view, $_data = NULL, $_return = FALSE) {
		/**
		 * This method loads a 'view' and implants the data into it,
		 * and if needed returns that value to be included in other views.
		 * 
		 * @param $_view - name of the view to be called.
		 * @param $_data - data that can be passed into the view to populate existing variables.
		 * @param $_return - if this is set to true it will pass the value out to user otherwise append to the output buffer.
		 */
		if (file_exists($this->conf_libs . 'views/' . $_view . '.php')) {
			if ($_data !== NULL)
				extract($_data, EXTR_OVERWRITE);
			$core =& $this;
			ob_start();
			include($this->conf_libs . 'views/' . $_view . '.php');
			$buffer = ob_get_contents();
			@ob_end_clean();
			if ($_return == TRUE)
				return $buffer;
			else
				$this->output .= $buffer;
		} elseif ($_view === NULL) {
			$this->output .= $_data;
		}
	}

	function views($_view, $_data = NULL, $_return = FALSE) {
		trigger_error("views() method deprecated, please use view() method instead.", E_USER_DEPRECATED);
		$this->view($_view,$_data,$_return);
	}

}
