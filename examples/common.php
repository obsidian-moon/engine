<?php
/**
 * Common file containing Core instantiation
 *
 * This file is where you will start the Core object and pass it to the rest of the
 * files in your application. This location is required by framework.
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
 *
 * @global Core   $core
 * @global Logger $logger
 */
require __DIR__ . '/config/environment.php';
session_start();
require dirname(__DIR__) . '/vendor/autoload.php';

use \DarkProspectGames\ObsidianMoonEngine\Core;
use \DarkProspectGames\ObsidianMoonEngine\Modules\Input as CoreInput;
use \Monolog\Handler\StreamHandler;
use \Monolog\Logger;

try {
    $core = new Core(
        [
            'modules' => [
                'input' => new CoreInput()
            ]
        ]
    );
    $logger = new Logger('ExampleApp');
    $logger->pushHandler(
        new StreamHandler($core->config('root') . '/logs/errors.log', Logger::DEBUG)
    );
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
