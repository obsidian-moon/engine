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
	
	function classes($class, $alternate_name="",$p3_cname=null)
	{
		/**
		 * This function will load classes as needed for the user to use.
		 * It will allow them to be accessible via $core->classname.
		 * 
		 * @param $class - This is the file and class name of the class being called.
		 * @param $alternate_name - This is what the user would like to name the variable if available.
		 */
		if (preg_match('/\//', $class))
		{
			$class_name = explode('/', $class);
			$class_name = end($class_name);
		}
		elseif ($p3_cname !== null)
		{
			$class_name = $p3_cname;
		}
		else
		{
			$class_name = $class;
		}

		if (preg_match('/^core\//', $class)) 
			$classes_location = $this->conf_core.'classes/'.$class_name.'.php';
		elseif (preg_match('/^third_party\//', $class)) 
			$classes_location = $this->conf_libs.$class.'.php';
		else 
			$classes_location = $this->conf_libs.'classes/'.$class.'.php';		
		$configs_location = $this->conf_libs.'configs/'.$class.'.php';
		if (file_exists($classes_location))
		{
			include($classes_location);
			if (class_exists($class_name))
			{
				if (file_exists($configs_location))
				{
					include($configs_location);
				}
				if ($alternate_name == "")
				{
					$alternate_name = $class_name;
				}
				if (!isset($this->$alternate_name)) {
					if (isset($config) && $config !== null)
					{	
						$this->$alternate_name = new $class_name($config);				
					}
					else
					{	
						$this->$alternate_name = new $class_name();
					}
					$this->$alternate_name->core =& $this;
					if (method_exists($this->$alternate_name, 'om_start')) {
						$this->$alternate_name->om_start();
					}	
					return true;
				}
				else
				{
					$this->error[] = "\$this->$alternate_name has already been set, could not reinstanciate it!";
				}
			}
		}	
	}

	function views($_view, $_data=NULL, $_return=FALSE)
	{
		/**
		 * This method loads a 'view' and implants the data into it,
		 * and if needed returns that value to be included in other views.
		 * 
		 * @param $_view - name of the view to be called.
		 * @param $_data - data that can be passed into the view to populate existing variables.
		 * @param $_return - if this is set to true it will pass the value out to user otherwise append to the output buffer.
		 */
		if (file_exists($this->conf_libs.'views/'.$_view.'.php'))
		{
			if ($_data !== NULL) extract($_data, EXTR_OVERWRITE);
			ob_start();
			include($this->conf_libs.'views/'.$_view.'.php');
			$buffer = ob_get_contents();
			@ob_end_clean();
			if ($_return == TRUE) return $buffer;
			else $this->output .= $buffer;
		}
	}
}
