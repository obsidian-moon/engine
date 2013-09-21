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
 * Control ControlMain
 *
 * This control is used to show the main index pages.
 *
 * @category obsidian-moon-engine
 * @package  ControlMain
 * @author   Alfonso E Martinez, III <admin@darkprospect.net>
 * @license  BSD https://darkprospect.net/BSD-License.txt
 * @link     https://github.com/DarkProspectGames/obsidian-moon-engine
 */
class ControlMain extends AbstractControl
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
     * This is used when there isn't a secondary parameter set.
     *
     * @return mixed
     */
    public function index()
    {
        // Declare some data to be passed to the layout shell.
        $this->data['meta'] = array(
            'keywords'    => 'Frameworks, PHP, Lightweight',
            'description' => 'An example app for the Obsidian Moon Engine.',
            'title'       => 'Index Page'
        );
        // Call the view that contains the content and return it to a variable.
        $this->data['content'] = $this->core->view('MainIndex', null, true);

        // Take the data and send it to the layout shell view for return.
        $this->core->view('Layout/Shell', $this->data);
    }

    /**
     * Secondary Page
     *
     * This is used to show what a second parameter shows.
     *
     * @return mixed
     */
    public function secondary()
    {
        // Declare some data to be passed to the layout shell.
        $this->data['meta'] = array(
            'keywords'    => 'Frameworks, PHP, Lightweight',
            'description' => 'An example app for the Obsidian Moon Engine.',
            'title'       => 'Index Page'
        );
        // Call the view that contains the content and return it to a variable.
        $this->data['content'] = $this->core->view('MainSecondary', null, true);

        // Take the data and send it to the layout shell view for return.
        $this->core->view('Layout/Shell', $this->data);
    }

    /**
     * This is called after the class is created. It allows us to run
     * commands that may rely on libraries not loaded yet from construct.
     *
     * @return void
     */
    public function start()
    {
    }
}