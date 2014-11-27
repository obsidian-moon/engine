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
namespace DarkProspectGames\ObsidianMoonEngine;

/**
 * Class AbstractModule
 *
 * This class is the structure of the modules used by the framework which are
 * loaded into the framework for later use for your applications.
 *
 * Extend the Abstract Module:
 *
 * <code>
 * <?php
 * // ./src/Modules/MyModule.php
 * namespace MyCompanyNamespace\MyApplication;
 *
 * use \DarkProspectGames\ObsidianMoonEngine\AbstractModule;
 * use \DarkProspectGames\ObsidianMoonEngine\Core;
 *
 * class MyModule extends AbstractModule
 * {
 *     //...
 * }
 *
 * </code>
 *
 * @package  DarkProspectGames\ObsidianMoonEngine
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.3.0 Allowing for implementations of modules.
 * @uses     Core
 * @used-by  Benchmark
 * @used-by  CoreException
 * @used-by  Input
 * @used-by  Routing
 * @abstract
 */
abstract class AbstractModule
{

    /**
     * @type Core     This will hold a reference to the Core class.
     */
    protected $core;

    /**
     * @type mixed[] This will hold the configurations for the module.
     */
    protected $configs;

    /**
     * Constructor class for a standard module.
     *
     * This method will be called when the class is instantiated. It automatically
     * adds the Core class to $this->core and any params to $this->config. All child modules
     * must call the parent as following if they want to modify the default behaviour of the
     * constructor, unless they want to totally overwrite the constructor:
     *
     * <code>
     * public function __construct(Core $core, array $configs = [])
     * {
     *     parent::__construct($core, $routing);
     *     //...
     * }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that the module
     * creator has an easier time with creating modules.
     *
     * @param Core  $core    The reference to the Core Class.
     * @param array $configs The configurations being passed to the module.
     *
     * @uses   Core
     * @return AbstractModule
     */
    public function __construct(Core $core, array $configs = [])
    {
        $this->core    = $core;
        $this->configs = $configs;
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
