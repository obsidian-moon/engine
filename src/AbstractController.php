<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @category  ObsidianMoonEngine
 * @package   obsidian-moon-development\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/obsidian-moon-development/obsidian-moon-engine/
 */
namespace ObsidianMoonDevelopment\ObsidianMoonEngine;

/**
 * Class AbstractController
 *
 * This class is the structure of the controls used by the framework which are
 * called by the framework in order to guide the application's flow.
 *
 * Extend the Abstract Module:
 *
 * <code>
 * <?php
 * // ./src/Controllers/MyController.php
 * namespace MyCompanyNamespace\MyApplication;
 *
 * use \ObsidianMoonDevelopment\ObsidianMoonEngine\AbstractController;
 * use \ObsidianMoonDevelopment\ObsidianMoonEngine\Core;
 *
 * class MyController extends AbstractController
 * {
 *     //...
 * }
 *
 * </code>
 *
 * @category ObsidianMoonEngine
 * @package  ObsidianMoonDevelopment\ObsidianMoonEngine
 * @author   Alfonso E Martinez, III <admin@darkprospect.net>
 * @license  MIT https://darkprospect.net/MIT-License.txt
 * @link     https://github.com/obsidian-moon-development/obsidian-moon-engine/
 * @since    1.3.0 Allowing for control routing.
 * @uses     Core
 * @abstract
 */
abstract class AbstractController
{
    /** Variable holding the Core */
    protected Core $core;

    /** Routes information gained from URI */
    protected array $routes = [];

    /** Data being passed to the controller */
    protected array $data = [];

    /**
     * Constructor class for a standard module.
     *
     * This function will be called when the control is instantiated. It
     * automatically adds the Core class to $this->core. All child controls must
     * call the parent as following if they want to modify the default behaviour of
     * the constructor, unless they want to totally overwrite the constructor:
     *
     * <code>
     * public function __construct(array $routes = [])
     * {
     *     parent::__construct($routes);
     *     //...
     * }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that
     * the module creator has an easier time with creating modules.
     *
     * @param string[] $routes Any extra routing that we get from routing module.
     *
     * @since 1.3.0
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * This happens after all the functions are complete.
     *
     * @since 1.3.0
     *
     * @return void
     */
    abstract public function end(): void;

    /**
     * Default Page
     *
     * This is used when there isn't any secondary parameter set.
     *
     * @since 1.3.0
     *
     * @return mixed
     */
    abstract public function index();

    /**
     * This is called when the class is created.
     *
     * <code>
     * public function start(Core $core)
     * {
     *     parent::start($core);
     *     //...
     * }
     * </code>
     *
     * @param Core $core Pass the Core to controller
     *
     * @since 1.3.0
     *
     * @return void
     */
    abstract public function start(Core $core): void;
}
