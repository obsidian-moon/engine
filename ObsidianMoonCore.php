<?php

/**
 * Obsidian Moon Engine presented by Dark Prospect Games
 *
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 *
 */
class ObsidianMoonCore
{

    public $conf_base;
    public $conf_core;
    public $conf_libs;
    public $error;
    public $is_ajax;
    public $is_http;
    public $output;
    public $systime;

    public function __construct($conf = null)
    {
        $this->systime = time();
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->is_ajax = true;
        }
        $this->is_http = $this->_get_protocol();
        // Assign all configuration values to $conf_**** variables
        if (isset($conf) && is_array($conf)) {
            foreach ($conf as $key => $value) {
                $var        = 'conf_' . $key;
                $this->$var = $value;
            }
        }
        if (isset($conf['modules'])) {
            try {
                $this->module($conf['modules']);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    function classes($modules, $alternate_name = "", $p3_mname = null)
    {
        trigger_error("classes() method is deprecated, please module() method instead.", E_USER_DEPRECATED);
        $this->module($modules, $alternate_name, $p3_mname);
    }

    function module($modules, $alternate_name = "", $p3_mname = null)
    {
        /**
         * This function will load classes as needed for the user to use.
         * It will allow them to be accessible via $core->modulename.
         *
         * @param $modules        - This is the file and class name of the class being called.
         * @param $alternate_name - This is what the user would like to name the variable if available.
         */
        if (!is_array($modules)) {
            $modules = array($modules => array($alternate_name, $p3_mname));
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
                $modules_location = $this->conf_libs . $module . '.php'; else
                $modules_location = $this->conf_libs . 'modules/' . $module . '.php';
            $configs_location = $this->conf_libs . 'configs/' . $module . '.php';
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
                            try {
                                $this->$alternate_name = new $module_name($this, $config);
                            } catch (Exception $e) {
                                error_log("Error Loading Module {$module_name}: " . $e->getMessage());
                            }
                        } else {
                            try {
                                $this->$alternate_name = new $module_name($this);
                            } catch (Exception $e) {
                                error_log("Error Loading Module {$module_name}: " . $e->getMessage());
                            }
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

    function view($_view, $_data = null, $_return = false)
    {
        /**
         * This method loads a 'view' and implants the data into it,
         * and if needed returns that value to be included in other views.
         *
         * @param $_view   - name of the view to be called.
         * @param $_data   - data that can be passed into the view to populate existing variables.
         * @param $_return - if this is set to true it will pass the value out to user otherwise append to the output buffer.
         *
         */
        if (file_exists("{$this->conf_libs}views/{$_view}.php")) {
            if ($_data !== null)
                extract($_data, EXTR_OVERWRITE);
            $core =& $this;
            ob_start();
            include("{$this->conf_libs}views/{$_view}.php");
            $buffer = ob_get_contents();
            @ob_end_clean();
            if ($_return)
                return $buffer;
            else
                $this->output .= $buffer;
        } elseif ($_view === null) {
            $this->output .= $_data;
        } else {
            throw new Exception("No view data could be found for 'views/{$_view}.php'!");
        }
        return true;
    }

    function views($_view, $_data = null, $_return = false)
    {
        trigger_error("views() method deprecated, please use view() method instead.", E_USER_DEPRECATED);
        $this->view($_view, $_data, $_return);
    }

    function _get_protocol()
    {
        // Check for Apache HTTPS
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
            return 'https';
        }
        // Check for Nginx HTTPS
        if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] === '443')) {
            return 'https';
        }
        return 'http';
    }

}
