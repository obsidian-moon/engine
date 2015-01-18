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
namespace DarkProspectGames\ObsidianMoonEngine\Modules;

use \DarkProspectGames\ObsidianMoonEngine\AbstractModule;

/**
 * Class Input
 *
 * A module to handle all of the input from $_POST, $_GET, $_SESSION, $_COOKIE and $_SERVER
 *
 * @package  DarkProspectGames\ObsidianMoonEngine\Modules
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.0.0
 * @uses     AbstractModule
 */
class Input extends AbstractModule
{

    /**
     * The function that will handle getting the data from the arrays.
     *
     * @param mixed   &$array    The array that will pulled from.
     * @param string  $index     What we are looking for.
     * @param boolean $xss_clean Whether to clean it or not or not. Incomplete.
     *
     * @return bool
     */
    protected function fetchFromArray(&$array, $index = '', $xss_clean = false)
    {
        if (!array_key_exists($index, $array)) {
            return false;
        }

        // Checks to see if the variable is set, since 0 returns as false.
        if ($xss_clean === 'isset') {
            return array_key_exists($index, $array);
        }

        return $array[$index];
    }

    /**
     * Grab values from the $_GET global.
     *
     * @param mixed   $index     The index that we will be searching for.
     * @param boolean $xss_clean Whether we want to clean it or not.
     *
     * @return mixed
     */
    public function get($index = null, $xss_clean = false)
    {
        if ($index === null && count($_GET) > 0) {
            $get = [];

            // Loop through the full $_GET array.
            foreach (array_keys($_GET) as $key) {
                $get[$key] = $this->fetchFromArray($_GET, $key, $xss_clean);
            }

            return $get;
        } else {
            return $this->fetchFromArray($_GET, $index, $xss_clean);
        }
    }

    /**
     * Grab values from the $_POST global.
     *
     * @param mixed   $index     The index that we will be searching for.
     * @param boolean $xss_clean Whether we want to clean it or not.
     *
     * @return mixed
     */
    public function post($index = null, $xss_clean = false)
    {
        // Check if a field has been provided.
        if ($index === null && count($_POST) > 0) {
            $post = [];

            // Loop through the full $_POST array and return the value.
            foreach (array_keys($_POST) as $key) {
                $post[$key] = $this->fetchFromArray($_POST, $key, $xss_clean);
            }

            return $post;
        } else {
            return $this->fetchFromArray($_POST, $index, $xss_clean);
        }
    }

    /**
     * Grab values from the $_COOKIE global.
     *
     * @param mixed   $index     The index that we will be searching for.
     * @param boolean $xss_clean Whether we want to clean it or not.
     *
     * @return mixed
     */
    public function cookie($index = '', $xss_clean = false)
    {
        return $this->fetchFromArray($_COOKIE, $index, $xss_clean);
    }

    /**
     * Grab values from the $_SERVER global.
     *
     * @param mixed   $index     The index that we will be searching for.
     * @param boolean $xss_clean Whether we want to clean it or not.
     *
     * @return mixed
     */
    public function server($index = '', $xss_clean = false)
    {
        return $this->fetchFromArray($_SERVER, $index, $xss_clean);
    }

    /**
     * Grab values from the $_SESSION global.
     *
     * @param mixed   $index     The index that we will be searching for.
     * @param boolean $xss_clean Whether we want to clean it or not.
     *
     * @return mixed
     */
    public function session($index = '', $xss_clean = false)
    {
        return $this->fetchFromArray($_SESSION, $index, $xss_clean);
    }

    /**
     * Set values in the $_SESSION global.
     *
     * @param mixed $index The index that we will be setting.
     * @param mixed $value Value of what we will be setting in the index.
     *
     * @return mixed
     */
    public function setSession($index = '', $value = '')
    {
        if (array_key_exists($index, $_SESSION))
        {
            return false;
        }

        $_SESSION[$index] = $value;

        return true;
    }

    /**
     * Remove values from the $_SESSION global.
     *
     * @param mixed $index The index that we will be removing.
     *
     * @return boolean
     */
    public function unsetSession($index = '')
    {
        unset($_SESSION[$index]);
        if (!array_key_exists($index, $_SESSION))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
