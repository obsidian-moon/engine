<?php

namespace ObsidianMoon\Engine\Abstracts;

use JetBrains\PhpStorm\Pure;
use ObsidianMoon\Engine\Handlers\ViewHandler;

/**
 *
 */
class AbstractController
{
    protected ViewHandler $view;

    #[Pure]
    public function __construct(protected string $viewsRoot)
    {
        $this->view = new ViewHandler($this->viewsRoot);
    }
}
