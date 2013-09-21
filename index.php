<?php
/**
 * Obsidian Moon Engine presented by Dark Prospect Games
 *
 * PHP version 5
 *
 * @category  obsidian-moon-engine
 * @package   ExampleApplication
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/obsidian-moon-engine
 */
/**
 * Creates the OME Core and passes all of the correct values to it.
 *
 * @category  obsidian-moon-engine
 * @package   ExampleApp
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/obsidian-moon-engine
 */
// Check to see if we have installed anything to the Composer vendor folder, if so load it.
if (file_exists('vendor/autoload.php')) {

    require 'vendor/autoload.php';
}

use \ObsidianMoonEngine\Core;

session_start();

// Set the default control for app and load input module.
$conf = array(
    'defcon'  => 'Main',
    'modules' => array(
                  'CoreInput' => 'input',
                 ),
);
try {
    // Create the instance and then run the routing.
    $core = new Core($conf);
    $core->routing();
} catch (Exception $e) {
    echo 'There was an error initializing the system, please try again! ' . $e->getMessage();
}
// The Core will echo out the output buffer after the class finishes
