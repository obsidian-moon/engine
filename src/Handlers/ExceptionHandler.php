<?php

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
