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
namespace DarkProspectGames\ObsidianMoonEngine\Controllers;

use \DarkProspectGames\ObsidianMoonEngine\AbstractController;

/**
 * Class Error404
 *
 * This is the default controller.
 *
 * @package  DarkProspectGames\ObsidianMoonEngine\Controllers
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.3.2
 * @uses     AbstractController
 */
class Error404 extends AbstractController {

    public function index()
    {
        $this->core->view(null, 'Unable to find the Controller you were trying to access!');
    }

    public function end()
    {
    }

    public function start()
    {
    }
} 