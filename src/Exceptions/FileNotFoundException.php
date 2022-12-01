<?php
/**
 * File Not Found Exception
 *
 * Thrown whenever we know the file is not present in the project.
 *
 * Obsidian Moon Engine by Obsidian Moon Development
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 8
 *
 * @category  Framework
 * @package   ObsidianMoon\Engine
 */
namespace ObsidianMoon\Engine\Exceptions;

use Exception;

/**
 * Thrown if a file or controller is not found.
 */
class FileNotFoundException extends Exception
{
}
