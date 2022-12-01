<?php
/**
 * Exception Handler
 *
 * This handler allows for the application to limit the information we broadcast about
 * errors in the application. We can set a custom message that is shown to the user instead of the actual
 * thrown error.
 *
 * Obsidian Moon Engine by Obsidian Moon Development
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 8
 *
 * @category  Framework
 * @package   ObsidianMoon\Engine
 */
namespace ObsidianMoon\Engine\Handlers;

use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Handle Exceptions and return the values if safe/admin.
 */
class ExceptionHandler
{
    public function __construct(protected bool $admin = false) {}

    #[Pure]
    public function handle(Exception $e, string $message = null): string
    {
        if ($this->admin) {
            return $e->getMessage();
        }

        return $message ?: 'We apologize, an error occurred. Please try again, or contact the admin if it persists.';
    }
}
