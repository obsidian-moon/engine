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

use \Exception;

/**
 * Class CoreException
 *
 * Used to handle any issues that we may have with the application.
 * You will be able to log errors automatically instead of dealing
 * with error_log() directly.
 *
 * @package  DarkProspectGames\ObsidianMoonEngine\Modules
 * @author   Alfonso E Martinez, III <alfonso@opensaurusrex.com>
 * @since    1.3.0
 * @uses     Exception
 */
class CoreException extends Exception
{

    /**
     * Constructor for CoreException
     *
     * This extends the standard Exception class in order
     *
     * @param  null|string   $message   The exception message
     * @param  Exception     $previous  Pass the Exception class to CoreException
     * @param  bool          $error_log Determines whether or not we will log the error in error_log
     * @return CoreException
     */
    public function __construct($message = null, Exception $previous = null, $error_log = true)
    {
        if ($message != null) {
            $this->message = $message;
        }

        if ($previous instanceof Exception) {
            if ($message == null) {
                $this->message = $previous->getMessage();
            }

            $this->code = $previous->getCode();
            $this->stack_trace = var_export($previous->getTrace(), true);
        }

        if ($error_log === true) {
            error_log("CoreException: {$this->message}\n");
        }

        parent::__construct($this->message, $this->code);
    }

    /**
     * Returns When Treated As String
     *
     * Allows a class to decide how it will react when it is treated like a string.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
