<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  obsidian-moon-engine-core
 * @package   obsidian-moon-engine-core
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link       https://gitlab.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine;

use \Exception;

/**
 * Class Core
 *
 * This class is the core of the framework and handles all of the loading and processing
 * of modules and controls that will be used by your application.
 *
 * @category  obsidian-moon-engine-core
 * @package   Core
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link       https://gitlab.com/dark-prospect-games/obsidian-moon-engine/
 */
class Core
{

    /**
     * @const Version of the Framework
     */
    const VERSION = '1.3.0';

    /**
     * @var mixed
     */
    protected $controls;

    /**
     * @var mixed
     */
    public $errors = array();

    /**
     * @var mixed The variable that stores the output that will be returned at
     *            the end of the script.
     */
    protected $output;

    /**
     * @var mixed An array holding all of the configurations that we created the Core with.
     */
    protected $configs;

    /**
     * @var mixed When the user creates variables in the Core, we assign them to this
     *            array for later referencing by the app.
     */
    protected $globals;

    /**
     * @var Core The current instance of a Core object.
     */
    protected static $instance = null;

    /**
     * @var mixed An array holding all of the Module objects currently loaded into Core.
     */
    protected $modules;

    /**
     * This creates an instance of the core class.
     *
     * @param mixed $conf This is an array that holds the configurations passed to the class.
     *
     * @throws Exception
     */
    public function __construct($conf = null)
    {
        $this->globals['systime'] = time();
        $this->globals['is_ajax'] = $this->getAjax();
        $this->globals['is_http'] = $this->getProtocol();
        // Assign all configuration values to $conf_**** variables.
        if (isset($conf) == true && is_array($conf) == true) {
            foreach ($conf as $key => $value) {
                $this->configs[$key] = $value;
            }
        }

        $this->configs['core'] = dirname(__FILE__);
        $this->configs['base'] = dirname($_SERVER['SCRIPT_FILENAME']);
        $this->configs['libs'] = $this->configs['base'] . '/src';

        // CoreRouting is default routing method, can be overwritten when specified.
        if (!isset($this->configs['routing'])) {
            $this->configs['routing'] = 'Core\Routing';
        }

        if (isset($conf['modules'])) {
            try {
                foreach ($conf['modules'] as $key => $value) {
                    $this->module($key, $value);
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    /**
     * We will automatically echo the framework's output buffer
     */
    public function __destruct()
    {
        if ($this->output) {
            echo $this->output;
        }
    }

    /**
     * Call either a module or a global from storage.
     *
     * This method will automatically grab the correct reference and return the
     * value as the app needs.
     *
     * @param mixed $name The global variable that is trying to be set.
     *
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if (preg_match('/^conf_/i', $name)) {
            $name = str_replace('conf_', '', $name);
            if (isset($this->configs[$name])) {
                return $this->configs[$name];
            } else {
                throw new Exception(
                    "Could not find a variable by the name 'conf_{$name}'!"
                );
            }
        } elseif (isset($this->modules[$name])) {
            return $this->modules[$name];
        } elseif (isset($this->globals[$name])) {
            return $this->globals[$name];
        } else {
            throw new Exception("Could not find a variable by the name '{$name}'!");
        }
    }

    /**
     * Global Setter
     *
     * We use this to set a global in the global storage array, however we don't
     * want them to be able to create variables that have prefix of 'conf_' since
     * that is reserved for framework configs.
     *
     * @param mixed $name  The global variable that is trying to be set.
     * @param mixed $value Value of the global that you are trying to set.
     *
     * @return boolean
     */
    public function __set($name, $value)
    {
        if (!preg_match('/^conf_/i', $name)) {
            $this->globals[$name] = $value;

            // Check to make sure that the value got set, and that it is correct.
            if (isset($this->globals[$name]) && $this->globals[$name] == $value) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Global toString
     *
     * We use this to return the name and version of Framework if they try to echo Core.
     *
     * @return string
     */
    public function __toString()
    {
        return 'Obsidian Moon Engine v'.self::VERSION.', Copyright (c) 2011-2013 Dark Prospect Games, LLC';
    }

    /**
     * Tests the server to see if the user has submitted an AJAX request.
     *
     * @return boolean
     */
    private function getAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Tests the server to see if it is running HTTP or HTTPS.
     *
     * @return string
     */
    private function getProtocol()
    {
        // Check for Apache HTTPS.
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
            return 'https';
        }

        // Check for Nginx HTTPS.
        if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] === '443')) {
            return 'https';
        }

        return 'http';
    }

    /**
     * This function will load classes as needed for the user to use.
     * It will allow them to be accessible via $core->modulename.
     *
     * @param string $moduleName This is the modules that will be loaded into the Core.
     * @param string $accessName This is the modules that will be loaded into the Core.
     * @param array  $config     This is the modules that will be loaded into the Core.
     *
     * @return boolean
     * @throws Exception
     */
    public function module($moduleName, $accessName, $config = null)
    {
        if (isset($this->modules[$accessName])) {
            throw new Exception(
                "Module '\$this->$accessName' has already been set,"
                ."could not instantiate module '$moduleName'!"
            );
        } else {
            if (isset($config) && $config !== null) {
                try {
                    $this->modules[$accessName] = new $moduleName($this, $config);
                } catch (Exception $e) {
                    throw new Exception("Error Loading Module {$moduleName}: " . $e->getMessage());
                }
            } else {
                try {
                    $this->modules[$accessName] = new $moduleName($this);
                } catch (Exception $e) {
                    throw new Exception("Error Loading Module {$moduleName}: " . $e->getMessage());
                }
            }

            if (method_exists($this->modules[$accessName], 'start')) {
                $this->modules[$accessName]->start();
            }
        }

        return true;
    }

    /**
     * Routing Caller
     *
     * We run the routing after all the modules etc have been loaded to make sure that
     * the correct Control is called.
     *
     * @throws Exception
     * @return void
     */
    public function routing()
    {
        try {
            $this->module('\\DarkProspectGames\\Modules\\Core\\Routing', 'routing');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Load a View into the System
     *
     * This method loads a 'view' and implants the data into it,
     * and if needed returns that value to be included in other views.
     *
     * <code>
     *     $this->core->view()
     * </code>
     *
     * @param mixed   $_view   Name of the view to be called.
     * @param mixed   $_data   Data that can be passed into the view to
     *                         populate existing variables.
     * @param boolean $_return If this is set to true it will pass the value
     *                         out to user otherwise append to the output buffer.
     *
     * @return mixed
     * @throws Exception
     */
    public function view($_view, $_data = null, $_return = false)
    {
        if (!file_exists($this->configs['libs'] . '/Views/' . $_view . '.php') && $_view !== null) {
            throw new Exception("No view data could be found for 'Views/{$_view}.php'!");
        } elseif ($_view === null) {
            $this->output .= $_data;
        } else {
            if ($_data !== null) {
                extract($_data, EXTR_OVERWRITE);
            }

            $core =& $this;
            ob_start();
            include $this->configs['libs'] . '/Views/' . $_view . '.php';
            $buffer = ob_get_contents();
            @ob_end_clean();
            if ($_return) {
                return $buffer;
            } else {
                $this->output .= $buffer;
            }
        }//end if

        return true;
    }
}
