<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  obsidian-moon-engine
 * @package   obsidian-moon-engine
 * @author    Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @copyright 2011-2014 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine;

/**
 * DarkProspectGames\ObsidianMoonEngine\AbstractModule
 *
 * This class is the structure of the modules used by the framework which are
 * loaded into the framework for later use for your applications.
 *
 * @category  obsidian-moon-engine-core
 * @package   AbstractModule
 * @author    Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @copyright 2011-2014 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 * @since     1.3.0 Allowing for implementations of modules.
 */
abstract class AbstractModule
{

    /**
     * @var Core This will hold a reference to the Core class.
     */
    protected $core;

    /**
     * @var mixed This will hold the configurations for the module.
     */
    protected $configs;

    /**
     * Constructor class for a standard module.
     *
     * This function will be called when the class is instantiated. It automatically
     * adds the Core class to $this->core and any params to $this->config. All child modules
     * must call the parent as following if they want to modify the default behaviour of the
     * constructor, unless they want to totally overwrite the constructor:
     *
     * <code>
     *     public function __construct(Core $core, $configs = null)
     *     {
     *         parent::__construct($core, $configs);
     *         // Add any custom coding after you include this in your constructor.
     *     }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that the module
     * creator has an easier time with creating modules.
     *
     * @param Core  $core    The reference to the Core Class.
     * @param mixed $configs The configurations being passed to the module.
     *
     * @return AbstractModule
     */
    public function __construct(Core $core, $configs = null)
    {
        $this->core = $core;
        if ($configs !== null) {
            $this->configs = $configs;
        }
    }

    /**
     * Post-initialization
     *
     * This function will be called if the user needs to have any tasks happen after the
     * initialization of the class.
     *
     * @return void
     */
    public function start()
    {
    }
}
