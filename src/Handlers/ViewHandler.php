<?php
/**
 * View Handler
 *
 * This handles the loading and implementation of the views when they are called.
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

use ObsidianMoon\Engine\Exceptions\FileNotFoundException;

/**
 * Handle view files using a modified version of the OME view function.
 */
class ViewHandler
{
    protected string $output = '';

    /**
     * @param string $viewsRoot The location where we are storing views.
     * @param array  $viewData  Default data we can pass to the view.
     */
    public function __construct(protected string $viewsRoot, protected array $viewData = [])
    {
    }

    /**
     * Handle the locating and processing of views from the application.
     *
     * @param string|null $view   Location of the view
     * @param array       $data   Pass data to be used in the view
     * @param bool        $return Will we return it or add it to output?
     *
     * @return bool|string
     * @throws FileNotFoundException
     */
    public function load(?string $view = null, array $data = [], bool $return = false): bool|string
    {
        /** Load default view data */
        if (count($this->viewData) > 0) {
            extract($this->viewData, EXTR_SKIP);
        }

        /** Are we sending data straight to output? */
        if ($view === null) {
            $this->output .= $data[0];

            return true;
        }

        /** The location of the View to be loaded */
        $fileName = $this->viewsRoot . '/' . $view . '.php';
        if (!file_exists($fileName)) {
            throw new FileNotFoundException("Could not find a view file at '$fileName'!");
        }

        /** Load data specific to this view */
        if (count($data) > 0) {
            extract($data);
        }

        /** Store the content in output or return it */
        ob_start();
        include $fileName;
        $buffer = ob_get_clean();
        if ($return) {
            return $buffer;
        }
        $this->output .= $buffer;

        return true;
    }

    /**
     * We render the output that is stored
     *
     * @return void
     */
    public function render(): void
    {
        echo $this->output;
    }
}
