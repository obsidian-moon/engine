<a name="2.0.1"></a>
# 2.0.1 ()

<a name="2.0.1.features"></a>
## Features

* Added a security policy in `SECURITY.md`.
* Added an optional `viewData` property to `AbstractController::__construct(viewsRoot: VIEWS_ROOT, viewData: [])` to 
  be passed to `ViewHandler`.

<a name="2.0.1.bug-fixes"></a>
## Bug Fixes

* Corrected the `CHANGELOG.md` for version  `2.0.0`, removed the unfinished `1.8.0` documentation.
* Cleaned up some minor code formatting.

<a name="2.0.0"></a>
# 2.0.0 (2022-01-05)

<a name="2.0.0.features"></a>
## Features

* Raised the minimum version of PHP to 8.1.
* With `2.0.0` we are moving the project from `dark-prospect-games/obsidian-moon-engine` to `obsidian-moon/engine` to
  make it more concise.
* Users can now run `composer create-project obsidian-moon/framework` to install a preconfigured project with 
  Obsidan Moon Engine pre-installed. See [Obsidian Moon Engine](https://github.com/obsidian-moon/framework) on GitHub 
  for more information.
* Added a handler for controllers called `ControllerHandler` which uses `symfony/routing`.
* Added a handler for views called `ViewHandler`:
  * Views will have access to default values via the `$this->viewData` property which can be passed values on
    instatiation of:
    ```php
    new ViewHandler(viewsRoot: VIEWS_ROOT, viewData: ['key' => 'value']) 
    ```

<a name="2.0.0.breaking-changes"></a>
## Breaking Changes

* `Core` class no longer exists. It has been replaced with a few handlers: `ControllerHandler`, `ExceptionHandler` and
  `ViewHandler`.
* We are now using `symfony/routing` and `symfony/http-foundation` to handle routing. See 
  [Obsidian Moon Framework](/obsidian-moon/framework) for how that is being implemented.
* We are no longer handling any configs within the framework itself, configs are handled by the application and that is
  passed to handlers, eg. `ViewsHandler::__construct(VIEWS_ROOT, $viewData)`
* Added an exception handler for differentiating how we handle the Exceptions. If `$this->admin` is instantiated to
  true, then we will 
* `Modules\Database` now has a default fetch mode of `PDO::FETCH_OBJ` which can be overwritten explicitely.

<a name="1.7.2"></a>
# 1.7.2 (2018-04-12)

<a name="1.7.2.bug-fixes"></a>
## Bug Fixes

* Fixing an issue with the `Core::view()` method so that we can use a `null` value in
  the `$_view` parameter and send the output to the browser without applying it to a
  view file.

<a name="1.7.1"></a>
# 1.7.1 (2018-04-08)

<a name="1.7.1.features"></a>
## Features

* Improving the `Core` class logic and improving performance.
* Refactoring to meet PSR2.

<a name="1.7.0"></a>
# 1.7.0 (2017-12-29)

<a name="1.7.0.features"></a>
## Features

* Now requiring there to be a `public` directory in which we will put all assets and the `index.php`.
* Included an `examples` directory with a simple example application, to show recommended file structure.This is a 
  working demo of the framework. Just make the directory root for test site `./examples/public` to see it in action, or 
  copy files from this into your new install!
  
<a name="1.6.0"></a>
# 1.6.0 (2017-11-24)

<a name="1.6.0.features"></a>
## Features

* Requiring PHP 7.1 as minimum requirement, due to it being the current stable.

<a name="1.5.3"></a>
# 1.5.3 (2017-10-17)

<a name="1.5.3.bug-fixes"></a>
## Bug Fixes

* Correcting an issue with the `DarkProspectGames\ObsidianMoonEngine\Modules\Database` class. It was not loading the 
  drivers correctly. Had to pass the default configs to the `parent::__construct()` after an `array_replace()`. Will 
  look into finding a better way to overload the inheritance that is compatible with PHP 7.0+.
* Updating the `composer.lock` with the correct updated information, after having removed `PHPUnit` from the 
  `composer.json`.

<a name="1.5.2"></a>
# 1.5.2 (2017-10-17)

<a name="1.5.2.bug-fixes"></a>
## Bug Fixes

* Correcting an issue with the `DarkProspectGames\ObsidianMoonEngine\Modules\Database` class. It was not loading the 
  drivers correctly. Declaring the configs in the class declaration was not working. I had to move the assigning to the 
  `__construct()` method, after which it will be overwritten by the configs passed to it.  

<a name="1.5.1"></a>
# 1.5.1 (2017-10-11)

<a name="1.5.1.features"></a>
## Features

* Added [scalar type declarations](http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration)
  to many of the methods in the core classes.
* Changed `use` calls of core classes to PHP 7.0 format.

<a name="1.5.0"></a>
# 1.5.0 (2017-10-10)

<a name="1.5.0.features"></a>
## Features

* Raised minimum PHP version from v5.5 to v7.0.
* Added a new method to `DarkProspectGames\ObsidianMoonEngine\Modules\Input` called `request()` that will handle
  `$_REQUEST` for you, however this should be used only for a single index due to security reasons.
* Updated the contact information throughout the project to match current contact details.

<a name="1.5.0.bug-fixes"></a>
## Bug Fixes

* Corrected a misspelled call of `array_key_exists()` in `DarkProspectGames\ObsidianMoonEngine\Modules\Database` in the 
  `fetchArray()` method.

<a name="1.4.2"></a>
# 1.4.2 (2015-01-25)

<a name="1.4.2.bug-fixes"></a>
## Bug Fixes

* Correcting an issue where I was seeing a general warning coming off of a query that contained a `SELECT` within a
  `WHERE` clause like the  following: `DELETE FROM table_name WHERE field_name NOT IN (SELECT field FROM other_table)`

<a name="1.4.1"></a>
# 1.4.1 (2015-01-24)

<a name="1.4.1.features"></a>
## Features

* Correcting an issue where we are checking for array key on a boolean.

<a name="1.4.0"></a>
# 1.4.0 (2015-01-18)

<a name="1.4.0.features"></a>
## Features

* Found extra information regarding PHPDocs so I include those changes as well.
* Removed `.htaccess` and placed contents in `README.md` under installation information.
* Removed the unused dependencies in `require-dev`
* Renamed the `Changelog.md` to `CHANGELOG.md`
* Added a core method named `data()` that will allow users to add view data that is available to all views, eg.:

  ```php
  use DarkProspectGames\MyApplication\Models\User;
  use DarkProspectGames\MyApplication\Modules\Handler;
  use DarkProspectGames\MyApplication\Modules\Random;
  
  $user    = User::find(1);
  $handler = new Handler();
  $core->data(['user' => $user, 'handler' => $handler]);
  // The above view data is now avaible to all views below, before view data passed to `view()`.
  $header = $core->view('layout/header', ['random' => new Random()], true);
  $core->view('layout/layout', ['header' => $header]);
  ```

<a name="1.4.0.breaking-changes"></a>
## Breaking Changes 

* Raised minimum PHP version from v5.4 to v5.5.
* Renamed `AbstractControl` to `AbstractController` and updated code documentation with examples.
* All of the modules use `DarkProspectGames\ObsidianMoonEngine\Core\CoreException`.
* `Core::module()` instead of instantiating an object for you, now only handles objects in the following manner:

  ```php
  use DarkProspectGames\ObsidianMoonEngine\Modules\Input as CoreInput;
  
  $core->module('newProperty', new CoreInput([/* array of configs */]));
  // Use that new object to set a session
  $core->newProperty->setSession('id', 1);
  ```

* View data will no longer overwrite using PHP's `EXTR_OVERWRITE`. Instead it will use `EXTR_SKIP` and thus skip any
  conflicting variables.
* Renamed the following properties: `is_ajax` to `isAjax`; `is_http` to `isHttp`; `systime` to `systemTime`.

<a name="1.3.1"></a>
# 1.3.1 (2014-10-01)

* Added the ability to change configs after the instantiation of the Database class.
* Removed the CouchDB class.
* Converted the license from BSD-3 to MIT.
* Updated all of the PhpDoc documentation.

<a name="1.3.0"></a>
# 1.3.0 (2014-08-27)

* Removed `CoreMysql` module from the framework with the deprecation of MySQL class in PHP 5.5.
  Please, use the `CorePDO` module instead, more optimizations will be introduced at a later time.
* Modules and Controls will not extend a superclass designed to provide a skeleton for each.
* Routing is now handled by a routing module which will default to `CoreRouting` if not specified.
* Added the ability to use subdirectories as the base of the application, for example:
  `http://myapplication.com/application/`. Check documentation for methods of using this in
  your application.
* Allowing users to customize their apps by adding additional optional configurations, `mycontrol` & `mymodule`.
* Added the ability to overwrite the configurations stored in  `Libraries/Configs` by passing an array to `module()`.
* Additional routing info will be passed to Control class into `$this->routes` to be used by an Controls that you
  create, this functionality will be included as a part of the CoreRouting module.
* Added the ability to modify how the routing runs by making sure it calls a `start()` method if exists.

<a name="1.2.3"></a>
# 1.2.3 (2013-04-12)

* Replaced Facebook Enhanced with Facebook Ignited `Version 1.3.1`, `not-ignited` branch.
* Added a check for `isset` to input module, so that we can see if the key is existent.

<a name="1.2.2"></a>
# 1.2.2 (2012-12-16)

* Upgraded Facebook Enhanced from `Version 1.0.3` to `Version 1.2.0` (with Facebook PHP SDK v3.2.1).
* Deprecated core_mysql class, will no longer contribute to it.
* Views can now use $core from within views, instead of needing to use $this.
* Core System will now throw exceptions to the application if there are errors during
  the calling of methods, please catch the exceptions.

<a name="1.2.1"></a>
# 1.2.1 (2012-07-31)

* Removed a lot of the useless MySQL Extension functions that plainly are not up to par with what I wanted.
* Removed the MySQLi class.
* Added the PDO Class to the system.
* Added the `core_pdo::last_id()` method (grabs the last insert id) to MySQL Extension and PDO Classes.

<a name="1.2.0"></a>
# 1.2.0 (2012-06-08)

* Added the core_benchmark class to use with Obsidian Moon Engine (advocaite).

<a name="1.1.0"></a>
# 1.1.0 (2012-06-07)

* Reformatted the framework to no longer require the Constants it previously needed.

<a name="1.0.1"></a>
# 1.0.1 (2011-12-14)

* Added the ability to import third party modules and classes.
