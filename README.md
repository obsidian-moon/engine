Obsidian Moon Engine
====================

This is a project that I have worked on for several years after wanting a completely modular framework. I am aiming for
lightweight and able to include any modules from other applications, etc.

<a name="installing"></a>
## Installing Obsidian Moon Engine

Since Obsidian Moon Engine uses [Composer](https://getcomposer.org/) you will need to install it before you can run the
code with it. Once you have installed Composer you will then be able to install it by running the following command:

```bash
composer require obsidian-moon/engine
```

Alternatively, you can install the [Obsidian Moon Framework](https://github.com/obsidian-moon/framework/) with a prebuilt
structure, by using the following command. Click the link for additional information.

```bash
composer create-project obsidian-moon/framework
```

<a name="implementation"></a>
## Implelementation

To see a complete implementation of these features review the
[common.php](https://github.com/obsidian-moon/framework/blob/master/common.php) file from the
[Obsidian Moon Framework](https://github.com/obsidian-moon/framework/).
However, below are expanded examples which you can read to see all the optional features in use.

### Controllers

Controllers are simple classes that hold methods that can be called from the `ControllerHandler` class. You can extend
the builtin abstract class `AbstractController` and pass it your views folder configuration, as follows:

```php
// app/Controllers/LandingController.php
class LandingController extends AbstractController
{
    /**
     * Required: Pass the `views` folder configuration to the abstract parent class.
     * Optional: Pass a set of default values which will be handed off to `ViewHandler`
     */
    public function __construct()
    {
        /**
         * Retrieve default data from database/session or declare statically...
         */
        $optionalDefaultValues = [
            'defaultKey1' => 'defaultValue1',
            'defaultKey2' => 'defaultValue2',
            // ...
        ];
        parent::__construct(viewsRoot: VIEWS_ROOT, viewData: $optionalDefaultValues);
    }
}
```

### Controller Handler

In your application, you can pass information regarding your controller from `symfony/routing` or by passing an array
with `_controller` declared. It will return a Symfony Response once the `ControllerHandler::render()` method is called,
and it has found the class and method declared:

```php
use ObsidianMoon\Engine\Handlers\ControllerHandler;
use ObsidianMoon\Framework\Controllers\LandingController;
use ObsidianMoon\Engine\Exceptions\FileNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Needs an array containing the following keys `_controller` as follows
 * For Symfony Routing, Replace array with: $matcher->match($request->getPathInfo())
 *
 * Throws FileNotFoundException, Symfony's ResourceNotFoundException, or Symfony's MethodNotAllowedException on error.
 */
try {
    $controller = new ControllerHandler(controller: ['_controller' => [LandingController::class, 'index']]);
    $response = $controller->render(); // Returns Symfony Responce object
} catch (FileNotFoundException | ResourceNotFoundException) {
    // Unable to find that file or route is undefined.
    $response = 'We could not find that page!';
} catch (MethodNotAllowedException) {
    // Sent because of unsupported method, e.g. `$_POST` instead of `$_GET`.
    $response = 'We are unable to process your request. Please try again!';
}
```

### Exception Handler

You can utilize the use of a custom Exception Handler to handle whether the error message is shown or a custom error is.
You can do so as follows:

```php
use ObsidianMoon\Engine\Exceptions\FileNotFoundException;
use ObsidianMoon\Engine\Handlers\ExceptionHandler;

/**
 * Setting `admin` to `false` will return the message we pass to `handle()` method. Otherwise, it will return the
 * message originally sent from initial exception.
 */
$exceptions = new ExceptionHandler(admin: false);

/** Useful in conjunction with the `ControllerHandler`. */
try {
    throw new FileNotFoundException('More detailed message for admins');
} catch (FileNotFoundException $e) {
    $message = $exceptions->handle($e, 'A public error message for non-admins and/or production');
}
```

### View Handler

The view handler will look for the location it is passed and find a file with the name that is declared and can return
its value, or store it in the output property for later use. There are various ways it can be used, but the most common
is as follows:

```php
use ObsidianMoon\Engine\Exceptions\FileNotFoundException;
use ObsidianMoon\Engine\Handlers\ViewHandler;

/** Optional default data that can be pulled from DB, session, or static variables to be used in the views. */
$optionalDefaultData = [
    'defaultKey1' => 'defaultValue1',
    'defaultKey2' => 'defaultValue2',
    // ...
];

try {
    /** Instantiate with VIEWS_ROOT constant set to `src/views` and prepare to make calls */
    $view = new ViewHandler(viewsRoot: VIEWS_ROOT, viewData: $optionalDefaultData);

    /** Load a view `src/views/landing/index.php`, pass it data, and return output to a variable */
    $landingContent = $view->load(view: 'landing/index', data: ['key1' => 'value1'], return: true)

    /** Take the landing content and insert it as a variable into `src/views/layouts/shell.php` */
    $view->load(view: 'layouts/shell', data: compact('landingContent'));

    /** Render the content that has been stored in the handler output. */
    $view->render();
} catch (FileNotFoundException $e) {
    // Did not find the file, handle the 404 here.
}
```

[Complete List of Changes](CHANGELOG.md)

<a name="credits"></a>
## Credits

Obsidian Moon Engine uses the following libraries and projects in its development:

* [PHP 8](https://www.php.net/) with [Composer](https://getcomposer.org/) package manager.
* [Symfony 6 Components](https://symfony.com/components) for HTTP Requests and Routing.

<a name="summary"></a>
## Summary of Obsidian Moon Engine

Most of the code for this is meant to keep it as modular as possible. With version `1.x` I found that I ended up having
to repeat a lot of the code because of how routing was unable to be handled automatically. Using symfony routes
components ended up solving that issue. However, I was forced to rewrite the code to where it was simpler. I hope
that you find this code as useful as I have. And, I will continue to add to it as I expand it with my projects.

Regards,<br>
Alfonso Martinez<br>
Obsidian Moon Development
