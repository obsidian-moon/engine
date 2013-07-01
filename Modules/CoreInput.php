<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  Frameworks
 * @package   ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 */
namespace ObsidianMoonEngine;
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * Class to handle all of the input from $_POST, $_GET, $_SESSION, $_COOKIE and $_SERVER
 *
 * @category  ObsidianMoonEngine
 * @package   CoreInput
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 */
class CoreInput extends Module
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
        if (!isset($array[$index])) {
            return false;
        }

        // Checks to see if the variable is set, since 0 returns as false.
        if ($xss_clean == 'isset') {
            return isset($array[$index]);
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
            $get = array();

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
            $post = array();

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
        if (isset($_SESSION[$index]) === false) {
            $_SESSION[$index] = $value;
        } else {
            return false;
        }

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
        if (empty($_SESSION[$index])) {
            return true;
        } else {
            return false;
        }
    }

}