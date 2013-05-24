<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  ObsidianMoonEngine
 * @package   ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/Obsidian-Moon-Engine
 *
 */
namespace ObsidianMoonEngine;
/**
 * Class ObsidianMoonCore\Module
 *
 * This class is the core of the framework and handles all of the
 * the modules that you will be using for your applications.
 *
 * @category ObsidianMoonEngine
 * @package  Module
 * @author   Alfonso E Martinez, III <admin@darkprospect.net>
 * @license  BSD https://darkprospect.net/BSD-License.txt
 * @link     https://github.com/DarkProspectGames/ObsidianMoonEngine
 * @since    1.3.0 Allowing for implementations of modules.
 */
abstract class Module
{

    /**
     * @var Core This will hold the Core Class reference.
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
     * adds the Core Class to $this->core and any params to $this->config. All child modules
     * must call the parent as following if they want to modify the default behaviour of the
     * constructor:
     *
     * <code>
     *     public function __construct(Core $core, $configs = null)
     *     {
     *         parent::__construct($core, $configs);
     *         // Continue with your custom constructor.
     *     }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that the module
     * creator has an easier time with creating modules.
     *
     * @param Core  $core    The reference to the Core Class.
     * @param mixed $configs The configurations being passed to the module.
     *
     * @return Module
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