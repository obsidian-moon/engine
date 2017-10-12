<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine;

use \DarkProspectGames\ObsidianMoonEngine\Modules\CoreException;

/**
 * Class Core
 *
 * This class is the core of the framework and handles all of the loading and processing
 * of modules and controls that will be used by your application.
 *
 * @package  DarkProspectGames\ObsidianMoonEngine
 * @author   Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @uses     AbstractController
 * @uses     AbstractModule
 * @uses     CoreException
 * @since    1.0.0 Created core module
 * @since    1.4.0 Handling objects passed to module instead of strings & added ability to have default view data.
 */
class Core
{

    /** @type string               Framework Version */
    const VERSION = '1.5.1';
    /** @type AbstractController[] Collection of controllers that can be used by the app. */
    protected $controls = [];
    /** @type mixed[]              Collection of models and modules that are available to all views. */
    protected $viewData = [];
    /** @type string               The variable that stores compiled output that will be returned at the end. */
    protected $output;
    /** @type mixed[]              Array holding all of the configurations that we created the Core with. */
    protected $configs  = [];
    /** @type mixed[]              Contains keys and values of variables set in app. */
    protected $globals  = [];
    /** @type AbstractModule[]     Array holding all of the Module objects currently loaded into Core. */
    protected $modules  = [];

    /** @type string[]             Collection of errors messages passed from the framework. */
    public $errors = [];

    /**
     * This creates an instance of the core class.
     *
     * @param array $conf {
     *     @type string   $core    Directory root of the Core
     *     @type string   $base    Directory root of the Application
     *     @type string   $libs    Directory root of the Application sources
     *     @type object[] $modules Collection of modules to pass to module() method.
     * }
     *
     * @since  1.0.0
     * @throws CoreException
     */
    public function __construct(array $conf = [])
    {
        $this->globals = [
            'systemTime' => time(),
            'isAjax'  => $this->getAjax(),
            'isHttp'  => $this->getProtocol(),
        ];

	    $this->configs = [
		    'core' => __DIR__,
		    'base' => dirname($_SERVER['SCRIPT_FILENAME']),
		    'libs' => dirname($_SERVER['SCRIPT_FILENAME']) . '/src',
	    ];
        // Assign all configuration values to $conf_**** variables.
        if (count($conf) > 0) {
            foreach ($conf as $key => $value) {
                $this->configs[$key] = $value;
            }
        }

        // CoreRouting is default routing method, can be overwritten when specified.
        if (!array_key_exists('routing', $this->configs)) {
            $this->configs['routing'] = '\DarkProspectGames\ObsidianMoonEngine\Modules\Routing';
        }

        if (array_key_exists('modules', $conf)) {
            try {
                foreach ($conf['modules'] as $key => $value) {
                    $this->module($key, $value);
                }
            } catch (CoreException $e) {
                throw new CoreException($e->getMessage());
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
     * @param string $name The global variable that is trying to be accessed.
     *
     * @return mixed
     * @throws CoreException
     */
    public function __get(string $name)
    {
        if (preg_match('/^conf_/i', $name)) {
            $name = str_replace('conf_', '', $name);
            if (array_key_exists($name, $this->configs)) {
                return $this->configs[$name];
            } else {
                throw new CoreException(
                    "Could not find a variable by the name 'conf_{$name}'!"
                );
            }
        } elseif (array_key_exists($name, $this->modules)) {
            return $this->modules[$name];
        } elseif (array_key_exists($name, $this->globals)) {
            return $this->globals[$name];
        } else {
            throw new CoreException("Could not find a variable by the name '{$name}'!");
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
     * @uses globals to store value of $value
     *
     * @return boolean
     */
    public function __set(string $name, $value)
    {
        if (!preg_match('/^conf_/i', $name)) {
            $this->globals[$name] = $value;

            // Check to make sure that the value got set, and that it is correct.
            if (array_key_exists($name, $this->globals) && $this->globals[$name] === $value) {
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
        return 'Obsidian Moon Engine v'.self::VERSION.', Copyright (c) 2011-2018 Dark Prospect Games, LLC';
    }

    /**
     * Tests the server to see if the user has submitted an AJAX request.
     *
     * @return boolean
     */
    private function getAjax()
    {
        if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
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
        if (array_key_exists('HTTPS', $_SERVER) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) {
            return 'https';
        }

        // Check for Nginx HTTPS.
        if (array_key_exists('SERVER_PORT', $_SERVER) && ($_SERVER['SERVER_PORT'] === '443')) {
            return 'https';
        }

        return 'http';
    }

    /**
     * This function will load classes as needed for the user to use.
     * It will allow them to be accessible via $core->modulename.
     *
     * @param string $moduleName   This is key name that we will save the module to.
     * @param object $moduleObject This is the modules that will be loaded into the Core.
     *
     * @return boolean
     * @throws CoreException
     */
    public function module(string $moduleName, $moduleObject)
    {
        if (array_key_exists($moduleName, $this->modules)) {
            throw new CoreException(
                "Module '\$this->$moduleName' has already been set!"
            );
        } else {
            if (method_exists($moduleObject, 'start')) {
                $moduleObject->start($this);
            }
            $this->modules[$moduleName] = $moduleObject;
        }

        return true;
    }

    /**
     * Routing Caller
     *
     * We run the routing after all the modules etc have been loaded to make sure that
     * the correct Control is called.
     *
     * @throws CoreException
     */
    public function routing()
    {
        $routingClass = $this->configs['routing'];
        try {
            $this->module('routing', new $routingClass());
        } catch (CoreException $e) {
            throw new CoreException($e->getMessage());
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
     * @param string  $_view   Name of the view to be called.
     * @param mixed[] $_data   Data that can be passed into the view to
     *                         populate existing variables.
     * @param bool    $_return If this is set to true it will pass the value
     *                         out to user otherwise append to the output buffer.
     *
     * @return mixed
     * @throws CoreException
     */
    public function view($_view, array $_data = [], bool $_return = false)
    {
        /** Load the default data before  */
        if (count($this->viewData) > 0)
        {
            extract($this->viewData, EXTR_SKIP);
        }

        if ($_view !== null && ! file_exists($this->configs['libs'] . '/Views/' . $_view . '.php')) {
            throw new CoreException("Could not find View in './src/Views/{$_view}.php'!");
        } elseif ($_view === null) {
            $this->output .= $_data;
        } else {
            if (count($_data) > 0) {
                extract($_data, EXTR_SKIP);
            }

            ob_start();
            include $this->configs['libs'] . '/Views/' . $_view . '.php';
            $buffer = ob_get_contents();
            ob_end_clean();
            if ($_return) {
                return $buffer;
            } else {
                $this->output .= $buffer;
            }
        }//end if

        return true;
    }

    /**
     * Adds data to be used in views
     *
     * This method will merge the data with current `viewData` values.
     *
     * @param array $modules A collection of modules that will be globally available in views.
     * @param bool  $reset   Whether to empty the data set before assigning new data.
     */
    public function data(array $modules, bool $reset = false)
    {
        if ($reset)
        {
            $this->viewData = [];
        }

        $this->viewData = array_merge($this->viewData, $modules);
    }
}
