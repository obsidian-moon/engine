<?php
/**
 * No page was found! Add to this!
 *
 * Obsidian Moon Engine by Dark Prospect Games
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
use DarkProspectGames\ObsidianMoonEngine\Modules\CoreException;

try {
    $content = 'We could not find the page you are looking for!';
    $core->view('layout/layout', compact('content'));
} catch (CoreException $e) {
    echo 'An error occurred! Please try refreshing the page.';
}
