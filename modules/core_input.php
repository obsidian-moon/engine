<?php


/**
 * Obsidian Moon Engine presented by Dark Prospect Games
 *
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 *
 */
class core_input {

	/**
	 * Based on CodeIgniters Input Class
	 */
	public $core;

	function _fetch_from_array(&$array, $index = '', $xss_clean = FALSE) {
        if (!isset($array[$index])) {
			return FALSE;
		}

        /**
         * Checks to see if the variable is set, since 0 returns as false
         */
		if ($xss_clean == 'isset') {
            return isset($array[$index]);
        }

		return $array[$index];
	}

	function get($index, $xss_clean = FALSE) {
		if ($index === NULL AND !empty($_GET)) {
			$get = array();

			// loop through the full _GET array
			foreach (array_keys($_GET) as $key) {
				$get[$key] = $this->_fetch_from_array($_GET, $key, $xss_clean);
			}
			return $get;
		} else {
            return $this->_fetch_from_array($_GET, $index, $xss_clean);
        }
	}

	function post($index = NULL, $xss_clean = FALSE) {
		// Check if a field has been provided
		if ($index === NULL AND !empty($_POST)) {
			$post = array();

			// Loop through the full _POST array and return it
			foreach (array_keys($_POST) as $key) {
				$post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean);
			}
			return $post;
		} else {
            return $this->_fetch_from_array($_POST, $index, $xss_clean);
        }
	}

	function get_post($index = '', $xss_clean = FALSE) {
		if (!isset($_POST[$index])) {
			return $this->get($index, $xss_clean);
		} else {
			return $this->post($index, $xss_clean);
		}
	}

	function cookie($index = '', $xss_clean = FALSE) {
		return $this->_fetch_from_array($_COOKIE, $index, $xss_clean);
	}

	function server($index = '', $xss_clean = FALSE) {
		return $this->_fetch_from_array($_SERVER, $index, $xss_clean);
	}

	function session($index = '', $xss_clean = FALSE) {
		return $this->_fetch_from_array($_SESSION, $index, $xss_clean);
	}

	function set_session($index = '', $value = '') {
		return $_SESSION[$index] = $value;
	}

	function unset_session($index = '') {
		unset($_SESSION[$index]);
	}

}