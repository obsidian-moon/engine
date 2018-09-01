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
 * @author    Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine\Controllers;

use \DarkProspectGames\ObsidianMoonEngine\AbstractController;

/**
 * Class Error404
 *
 * This is the default controller.
 *
 * @category ObsidianMoonEngine
 * @package  DarkProspectGames\ObsidianMoonEngine\Controllers
 * @author   Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @license  MIT https://darkprospect.net/MIT-License.txt
 * @link     https://github.com/dark-prospect-games/obsidian-moon-engine/
 * @since    1.3.2
 * @uses     AbstractController
 */
class Error404 extends AbstractController
{
    /**
     * Index View for Missing Pages
     *
     * This will show when there is a 404 Error.
     *
     * @since  1.3.2
     * @throws \DarkProspectGames\ObsidianMoonEngine\Modules\CoreException
     * @return void
     */
    public function index(): void
    {
        $this->core->view(
            null,
            ['Unable to find the Controller you were trying to access!']
        );
    }

    /**
     * This happens after all of the functions are complete.
     *
     * @since  1.3.2
     * @return void
     */
    public function end(): void
    {
    }

    /**
     * This is called when the class is created.
     *
     * @since  1.3.2
     * @return void
     */
    public function start(): void
    {
    }
}
