<?php
/**
 * An abstract for Controllers
 *
 * All controllers will build onto this abstract, adding methods which can be run
 * when the routes are accessed.
 *
 * Obsidian Moon Engine by Obsidian Moon Development
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 8
 *
 * @category  Framework
 * @package   ObsidianMoon\Engine
 */
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
    public function __construct(protected string $viewsRoot, array $viewData = [])
    {
        $this->view = new ViewHandler($this->viewsRoot, $viewData);
    }
}
