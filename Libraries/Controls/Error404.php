<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  obsidian-moon-engine
 * @package   obsidian-moon-engine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/obsidian-moon-engine
 */
namespace ObsidianMoonEngine\Controls;

use ObsidianMoonEngine\AbstractControl;

/**
 * Control ControlError404
 *
 * This is the controller that handles what happens when a page is not found.
 *
 * @category obsidian-moon-engine
 * @package  ControlError404
 * @author   Alfonso E Martinez, III <admin@darkprospect.net>
 * @license  BSD https://darkprospect.net/BSD-License.txt
 * @link     https://github.com/DarkProspectGames/obsidian-moon-engine
 */
class ControlError404 extends AbstractControl
{

    /**
     * This is called after all of the functions and routing are complete.
     *
     * @return void
     */
    public function end()
    {
    }

    /**
     * Default Page
     *
     * This is used when there isn't any secondary parameter set.
     *
     * @return mixed
     */
    public function index()
    {
        // Declare some data to be passed to the layout shell.
        $this->data['meta']    = array(
                                  'keywords'    => 'Frameworks, PHP, Lightweight',
                                  'description' => 'An example app for the Obsidian Moon Engine.',
                                  'title'       => 'Page Not Found'
                                 );
        // Call the view that contains the content and return it to a variable.
        $this->data['content'] = $this->core->view('Error404', null, true);

        // Take the data and send it to the layout shell view for return.
        $this->core->view('Layout/Shell', $this->data);
    }

    /**
     * This is called when the class is created.
     *
     * @return void
     */
    public function start()
    {
    }

}