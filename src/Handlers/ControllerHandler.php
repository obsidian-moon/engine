<?php

namespace ObsidianMoon\Engine\Handlers;

use ObsidianMoon\Engine\Abstracts\AbstractController;
use ObsidianMoon\Engine\Exceptions\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ControllerHandler
{
    protected AbstractController $controller;
    protected string $method;
    protected array $attributes;

    /**
     * @param array $controller
     * @throws FileNotFoundException
     */
    public function __construct(array $controller)
    {
        if (!array_key_exists(key: '_controller', array: $controller)) {
            throw new FileNotFoundException('Could not find the Controller. No controller attribute supplied!');
        }

        if (!class_exists($controller['_controller'][0])) {
            throw new FileNotFoundException(
                'Could not find the Controller. Supplied controller is: ' . $controller['_controller'][0]
            );
        }

        $this->attributes = array_diff_key($controller, ['_controller' => 0, '_route' => 0]);
        $this->controller = new $controller['_controller'][0];
        $this->method = $controller['_controller'][1];
    }

    /**
     * @return Response
     * @throws FileNotFoundException
     */
    public function render(): Response
    {
        if (!method_exists($this->controller, $this->method)) {
            throw new FileNotFoundException('Could not find the "' . $this->method . '" method on the Controller.');
        }

        return $this->controller?->{$this->method}(...$this->attributes);
    }
}