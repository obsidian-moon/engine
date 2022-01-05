<?php

namespace ObsidianMoon\Engine\Handlers;

use ObsidianMoon\Engine\Exceptions\FileNotFoundException;

/**
 * Handle view files using a modified version of the OME view function.
 */
class ViewHandler
{
    protected string $output = '';

    public function __construct(protected string $viewsRoot, protected array $viewData = [])
    {
    }

    /**
     * Handle the locating and processing of views from the application.
     *
     * @param string|null $view Location of the view
     * @param array $data
     * @param bool $return
     * @return bool|string
     * @throws FileNotFoundException
     */
    public function load(?string $view = null, array $data = [], bool $return = false): bool|string
    {
        $content = '';

        if (\count($this->viewData) > 0) {
            extract($this->viewData, EXTR_SKIP);
        }

        // Are we sending data straight to output?
        if ($view === null) {
            $this->output .= $data[0];

            return true;
        }

        // The location of the View to be loaded
        $fileName = $this->viewsRoot . '/' . $view . '.php';
        if (!file_exists($fileName)) {
            throw new FileNotFoundException("Could not find a view file at '{$fileName}'!");
        }

        if (\count($data) > 0) {
            extract($data, EXTR_SKIP);
        }

        ob_start();
        include $fileName;
        $buffer = ob_get_clean();
        if ($return) {
            return $buffer;
        }
        $this->output .= $buffer;

        return true;
    }

    public function render(): void
    {
        echo $this->output;
    }
}
