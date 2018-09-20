<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @category  ObsidianMoonEngine
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2018 Dark Prospect Games, LLC
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
 * @category ObsidianMoonEngine
 * @package  DarkProspectGames\ObsidianMoonEngine
 * @author   Alfonso E Martinez, III <admin@darkprospect.net>
 * @license  MIT https://darkprospect.net/MIT-License.txt
 * @link     https://github.com/dark-prospect-games/obsidian-moon-engine/
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
     * This will hold a reference to the Core class.
     *
     * @type Core
     */
    protected $core;
    /**
     * This will hold the configurations for the module.
     *
     * @type mixed[]
     */
    protected $configs;

    /**
     * Constructor class for a standard module.
     *
     * This method will be called when the class is instantiated. It automatically
     * adds the Core class to $this->core and any params to $this->config. All child
     * modules must call the parent as following if they want to modify the default
     * behaviour of the constructor, unless they want to totally overwrite the
     * constructor:
     *
     * <code>
     * public function __construct(array $configs = [])
     * {
     *     parent::__construct($configs);
     *     //...
     * }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that
     * the module creator has an easier time with creating modules.
     *
     * @param array $configs The configurations being passed to the module.
     *
     * @uses  Core
     * @since 1.3.0
     */
    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
    }

    /**
     * Post-initialization
     *
     * This function will be called to store the Core Class in the core property.
     * Addditionally, if the user needs to have any tasks happen after the
     * initialization of the class, they will be able to overload the method by
     * doing the following:
     *
     * <code>
     * public function start(Core $core)
     * {
     *     parent::start($core);
     *     //...
     * }
     * </code>
     *
     * @param Core $core The reference to the Core Class.
     *
     * @since 1.3.0
     *
     * @return void
     */
    public function start(Core $core): void
    {
        $this->core = $core;
    }
}
