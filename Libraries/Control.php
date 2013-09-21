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
 * @link      https://github.com/DarkProspectGames/obsidian-moon-engine-core
 */
/**
 * Class Control
 *
 * This class is the structure of the controls used by the framework which are
 * called by the framework in order to guide the application's flow.
 *
 * @category  obsidian-moon-engine-core
 * @package   Control
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/obsidian-moon-engine-core
 * @since     1.3.0 Allowing for implementations of modules.
 */
abstract class Control
{

    /**
     * @var Core
     */
    protected $core;

    /**
     * @var mixed
     */
    protected $routes = array();

    /**
     * Constructor class for a standard module.
     *
     * This function will be called when the control is instantiated. It automatically
     * adds the Core class to $this->core. All child controls must call the parent as
     * following if they want to modify the default behaviour of the constructor, unless
     * they want to totally overwrite the constructor:
     *
     * <code>
     *     public function __construct(Core $core, $routing)
     *     {
     *         parent::__construct($core, $routing);
     *         // Add any custom coding to your constructor.
     *     }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that the module
     * creator has an easier time with creating modules.
     *
     * @param Core  $core   The reference to the Core class.
     * @param mixed $routes Any extra routing that we get from routing module.
     *
     * @return \obsidian-moon-engine-core\Control
     */
    public function __construct(Core $core, $routes)
    {
        $this->core   = $core;
        $this->routes = $routes;
    }

    /**
     * This happens after all of the functions are complete.
     *
     * @return void
     */
    abstract public function end();

    /**
     * Default Page
     *
     * This is used when there isn't any secondary parameter set.
     *
     * @return mixed
     */
    abstract public function index();

    /**
     * This is called when the class is created.
     *
     * @return void
     */
    abstract public function start();

}