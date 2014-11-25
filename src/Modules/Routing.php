<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @copyright 2011-2015 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine\Modules;

use \DarkProspectGames\ObsidianMoonEngine\Core;
use \DarkProspectGames\ObsidianMoonEngine\AbstractModule;

/**
 * Class Routing
 *
 * This module will handle the routing for the application.
 *
 * You are able to extend and customize the Routing module:
 *
 *
 * <code>
 * <?php
 * // ./src/Modules/MyRouting.php
 * namespace MyCompanyNamespace\MyApplication;
 *
 * use \DarkProspectGames\ObsidianMoonEngine\Modules\Routing;
 * use \DarkProspectGames\ObsidianMoonEngine\Core;
 *
 * class MyRouting extends Routing
 * {
 *     //...
 * }
 *
 * </code>
 *
 * @package  DarkProspectGames\ObsidianMoonEngine\Modules
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.3.0
 * @uses     Core
 * @uses     AbstractModule
 */
class Routing extends AbstractModule
{

    /**
     * @var string
     */
    protected $primary = '';

    /**
     * @var string
     */
    protected $secondary = '';

    /**
     * @var mixed
     */
    protected $params = [];

    /**
     * @var mixed
     */
    protected $control;

    /**
     * Constructor class for a standard module.
     *
     * This will load the routing information, it will load the primary route first
     * and then the secondary if set. Below are examples of what is called:
     *
     * - `/main/` loads `./src/Controllers/Main.php` with class and method `Main::index()`
     * - `/main/about/` loads `./src/Controllers/Main.php` with class and method `Main::about()`
     *
     * @param Core  $core    The reference to the Core Class.
     * @param array $configs The configurations being passed to the module.
     *
     * @uses   AbstractModule
     * @uses   Core
     * @return Routing
     */
    public function __construct(Core $core, $configs = [])
    {
        parent::__construct($core, $configs);

        // Get the URI from the system and process it into $this->primary and $this->params.
        $filter = ['/\?.*$/i'];
        if (isset($this->core->conf_subdir)) {
            $filter[] = "/{$this->core->conf_subdir}/i";
        }

        $uri           = explode('/', trim(preg_replace($filter, '', $_SERVER['REQUEST_URI']), '/'));
        $this->primary = ucfirst($uri[0]);
        $this->params  = array_slice($uri, 1);

        // If there is a second parameter we want to pull that and use it.
        if (isset($this->params[0])) {
            $this->secondary = $this->params[0];
            $this->params    = array_slice($this->params, 1);
        }
    }

    /**
     * Calls control
     *
     * This will create and run all of the methods for a Control
     *
     * To create your own routing you can create a new start method with your app's namespace and customize it:
     *
     * <code>
     * public function start()
     * {
     *     // check if we have a default controller set in our core configs, or use a default 404.
     *     if ($this->primary === '') {
     *         $this->primary = ($this->core->conf_defcon) ? $this->core->conf_defcon : 'Error404';
     *     }
     *
     *     $control_name = "\\MyCompanyNamespace\\MyApplication\\Controllers\\{$this->primary}";
     *     if (class_exists($control_name)) {
     *         // If the control exists we pass core and params to it.
     *         $this->control = new $control_name($this->core, $this->params);
     *     }
     *
     *     if (method_exists($this->control, 'start')) {
     *         $this->control->start();
     *     }
     *
     *     if (isset($this->secondary) && method_exists($this->control, $this->secondary)) {
     *         call_user_func_array([$this->control, $this->secondary], $this->params);
     *     } else {
     *         $this->control->index();
     *     }
     * }
     * </code>
     *
     * @return void
     */
    public function start()
    {
        if ($this->primary === '') {
            $this->primary = ($this->core->conf_defcon) ? $this->core->conf_defcon : 'Error404';
        }

        $control_name = "\\DarkProspectGames\\ObsidianMoonEngine\\Controllers\\{$this->primary}";
        if (class_exists($control_name)) {
            // If the control exists we pass core and params to it.
            $this->control = new $control_name($this->core, $this->params);
        }

        if (method_exists($this->control, 'start')) {
            $this->control->start();
        }

        if (isset($this->secondary) && method_exists($this->control, $this->secondary)) {
            call_user_func_array([$this->control, $this->secondary], $this->params);
        } else {
            $this->control->index();
        }
    }
}
