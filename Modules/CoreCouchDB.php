<?php
/**
 * Obsidian Moon Engine by Dark Prospect Games
 *
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 5
 *
 * @category  ObsidianMoonEngine
 * @package   ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 */
namespace ObsidianMoonEngine;
/**
 * Module ObsidianMoonEngine\CoreCouchDB
 *
 * Database class for CouchDB [Experimental!]
 *
 * @category  ObsidianMoonEngine
 * @package   CoreCouchDB
 * @author    Alfonso E Martinez, III <admin@darkprospect.net>
 * @copyright 2011-2013 Dark Prospect Games, LLC
 * @license   BSD https://darkprospect.net/BSD-License.txt
 * @link      https://github.com/DarkProspectGames/ObsidianMoonEngine
 *
 */
class CoreCouchDB extends Module
{

    /**
     * @var mixed
     */
    private $_headers;

    /**
     * @var mixed
     */
    private $_body;

    /**
     * Send the request for CouchDB
     *
     * @param mixed  $method    Method we will use to access DB.
     * @param string $url       Url to be called.
     * @param mixed  $post_data Data to be posted to the Database.
     *
     * @return bool
     */
    public function send($method, $url, $post_data = null)
    {
        $s = fsockopen($this->configs['host'], $this->configs['port'], $errno, $errstr);
        if (!$s) {
            echo "$errno: $errstr\n";

            return false;
        }

        $request = "$method $url HTTP/1.0\r\nHost: {$this->configs['host']}\r\n";

        if ($this->configs['user']) {
            $request .= 'Authorization: Basic ' . base64_encode("{$this->configs['user']}:{$this->configs['pass']}") . "\r\n";
        }

        if ($post_data) {
            $request .= 'Content-Length: ' . strlen($post_data) . "\r\n\r\n";
            $request .= "$post_data\r\n";
        } else {
            $request .= "\r\n";
        }

        fwrite($s, $request);
        $response = '';

        while (!feof($s)) {
            $response .= fgets($s);
        }

        list($this->_headers, $this->_body) = explode("\r\n\r\n", $response);

        return $this->_body;
    }

}