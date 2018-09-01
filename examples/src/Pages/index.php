<?php
/**
 * A basis core index page to expand on
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
use DarkProspectGames\ExampleApp\Modules\ExampleModule;
use DarkProspectGames\ObsidianMoonEngine\Modules\CoreException;

try {
    $core->module('example', new ExampleModule());
    $content = $core->view(
        'index',
        ['greeting' => $core->example->sayHello('World')],
        true
    );
    $core->view('layout/layout', compact('content'));
} catch (CoreException $e) {
    echo 'An error occurred! Please try refreshing the page.';
    $logger->error($e->getMessage(), ['page' => 'index']);
}
