<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
namespace DarkProspectGames\ObsidianMoonEngine\Modules;

use DarkProspectGames\ObsidianMoonEngine\AbstractModule;

/**
 * Module CoreBenchmark
 *
 * Loosely inspired by CodeIgniter's benchmark class, this module calculates the
 * time it takes to load the application's resources.
 *
 * @package DarkProspectGames\ObsidianMoonEngine\Modules
 * @author  Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @uses    AbstractModule
 */
class Benchmark extends AbstractModule
{

    /**
     * @type array List of all benchmark markers and when they were added.
     */
    private $marker = [];

    /**
     * Set a benchmark marker
     *
     * Multiple calls to this function can be made so that several
     * execution points can be timed
     *
     * @param string $name name of the marker
     *
     * @access public
     *
     * @return void
     */
    public function mark($name)
    {
        $this->marker[$name] = microtime();
    }

    /**
     * Calculates the time difference between two marked points.
     *
     * If the first parameter is empty this function instead returns the
     * {elapsed_time} pseudo-variable. This permits the full system
     * execution time to be shown in a template. The output class will
     * swap the real value for this variable.
     *
     * @param string  $point1   a particular marked point
     * @param string  $point2   a particular marked point
     * @param integer $decimals the number of decimal places
     *
     * @access public
     * @return mixed
     */
    public function elapsedTime($point1 = '', $point2 = '', $decimals = 4)
    {
        if ($point1 === '') {
            return '{elapsed_time}';
        }

        if (!array_key_exists($point1, $this->marker)) {
            return '';
        }

        if (!array_key_exists($point2, $this->marker)) {
            $this->marker[$point2] = microtime();
        }

        list($sm, $ss) = explode(' ', $this->marker[$point1]);
        list($em, $es) = explode(' ', $this->marker[$point2]);

        return number_format((($em + $es) - ($sm + $ss)), $decimals);
    }

    /**
     * Memory Usage
     *
     * This function returns the {memory_usage} pseudo-variable.
     * This permits it to be put it anywhere in a template
     * without the memory being calculated until the end.
     * The output class will swap the real value for this variable.
     *
     * @access    public
     * @return    string
     */
    public function memoryUsage()
    {
        return '{memory_usage}';
    }
}
