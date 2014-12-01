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
 * use \DarkProspectGames\ObsidianMoonEngine\AbstractController;
 * use \DarkProspectGames\ObsidianMoonEngine\Core;
 *
 * class MyController extends AbstractController
 * {
 *     //...
 * }
 *
 * </code>
 *
 * @package  DarkProspectGames\ObsidianMoonEngine
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.3.0 Allowing for control routing.
 * @uses     Core
 * @abstract
 */
abstract class AbstractController
{

    /** @type Core */
    protected $core;
    /** @type mixed[] */
    protected $routes = [];
    /** @type mixed[] */
    protected $data = [];

    /**
     * Constructor class for a standard module.
     *
     * This function will be called when the control is instantiated. It automatically
     * adds the Core class to $this->core. All child controls must call the parent as
     * following if they want to modify the default behaviour of the constructor, unless
     * they want to totally overwrite the constructor:
     *
     *
     * <code>
     * public function __construct(array $routes = [])
     * {
     *     parent::__construct($routes);
     *     //...
     * }
     * </code>
     *
     * This helps ensure that all modules are using the same implementation and that the module
     * creator has an easier time with creating modules.
     *
     * @param string[] $routes Any extra routing that we get from routing module.
     *
     * @uses Core Core module used in all controlls.
     */
    public function __construct(array $routes = [])
    {
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
