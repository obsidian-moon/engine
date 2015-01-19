<a name="1.4.0"></a>
# 1.4.0 (2015-01-18)

## Features

- Found extra information regarding PHPDocs so I include those changes as well.
- Removed `.htaccess` and placed contents in `README.md` under installation information.
- Removed the unused dependencies in `require-dev`
- Renamed the `Changelog.md` to `CHANGELOG.md`
- Added a core method named `data()` that will allow users to add view data that is available to all views.

## Breaking Changes 

- Raised minumum PHP version to v5.5.
- Renamed `AbstractControl` to `AbstractController` and updated Documentation with examples.
- All of the modules use `DarkProspectGames\ObsidianMoonEngine\Core\CoreException`.
- `Core::module()` instead of instantiating an object for you, now only handles objects in the following manner:
  
  ```php
  use \DarkProspectGames\ObsidianMoonEngine\Modules\Input as CoreInput;
  $core->module('newProperty', new CoreInput([/* array of configs */]));
  // Use that new object
  $core->newProperty->setSession('id', 1);
  ```
  
- View data will no longer overwrite using PHP's `EXTR_OVERWRITE`. Instead it will use `EXTR_SKIP` and thus skip any
  conflicting variables.
- Renamed the following properties: `is_ajax` to `isAjax`; `is_http` to `isHttp`; `systime` to `systemTime`.

<a name="1.3.1"></a>
# 1.3.1 (2014-10-01)

- Added the ability to change configs after the instantiation of the Database class.
- Removed the CouchDB class.
- Converted the license from BSD-3 to MIT.
- Updated all of the PhpDoc commentation.

<a name="1.3.0"></a>
# 1.3.0 (2014-08-27)

- Removed `CoreMysql` module from the framework with the deprecation of MySQL class in PHP 5.5.
  Please, use the `CorePDO` module instead, more optimizations will be introduced at a later time.
- Modules and Controls will not extend a superclass designed to provide a skeleton for each.
- Routing is now handled by a routing module which will default to `CoreRouting` if not specified.
- Added the ability to use subdirectories as the base of the application, for example:
  `http://myapplication.com/application/`. Check documentation for methods of using this in
  your application.
- Allowing users to customize their apps by adding additional optional configurations, `mycontrol` & `mymodule`.
- Added the ability to overwrite the configurations stored in  `Libraries/Configs` by passing an array to `module()`.
- Additional routing info will be passed to Control class into `$this->routes` to be used by an Controls that you
  create, this functionality will be included as a part of the CoreRouting module.
- Added the ability to modify how the routing runs by making sure it calls a `start()` method if exists.

<a name="1.2.3"></a>
# 1.2.3 (2013-04-12)

- Replaced Facebook Enhanced with Facebook Ignited `Version 1.3.1`, `not-ignited` branch.
- Added a check for isset to input module, so that we can see if the key is existant.

<a name="1.2.2"></a>
# 1.2.2 (2012-12-16)

- Upgraded Facebook Enhanced from `Version 1.0.3` to `Version 1.2.0` (with Facebook PHP SDK v3.2.1).
- Deprecated core_mysql class, will no longer contribute to it.
- Views can now use $core from within views, instead of needing to use $this.
- Core System will now throw exceptions to the application if there are errors during
  the calling of methods, please catch the exceptions.

<a name="1.2.1"></a>
# 1.2.1 (2012-07-31)

- Removed a lot of the useless MySQL Extension functions that plainly aren't up to par with what I wanted.
- Removed the MySQLi class.
- Added the PDO Class to the system.
- Added the `core_pdo::last_id()` method (grabs the last insert id) to MySQL Extension and PDO Classes.

<a name="1.2.0"></a>
# 1.2.0 (2012-06-08)

- Added the core_benchmark class to use with Obsidian Moon Engine (advocaite).

<a name="1.1.0"></a>
# 1.1.0 (2012-06-07)

- Reformatted the framework to no longer require the Constants it previously needed.

<a name="1.0.1"></a>
# 1.0.1 (2011-12-14)

- Added the ability to import third party modules and classes.