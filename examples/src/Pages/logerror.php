<?php
/**
 * We caused a log to happen on purpose to show you how it works.
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
    $content = 'We have added a log to `logs/errors.log`!';
    $logger->info('Logger loaded. We successfully saved an info log.');
    $core->view('layout/layout', compact('content'));
} catch (CoreException $e) {
    echo 'An error occurred! Please try refreshing the page.';
}
