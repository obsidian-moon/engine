## Obsidian Moon Engine Change Log

#### Version 1.3.0
- Removed `CoreMysql` module from the framework with the deprecation of MySQL class in PHP 5.5.
  Please, use the `CorePDO` module instead, more optimizations will be introduced at a later time.
- Modules and Controls will not extend a superclass designed to provide a skeleton for each.
- Routing is now handled by a routing module which will default to `CoreRouting` if not specified.
- Added the ability to use subdirectories as the base of the application, for example:
  `http://my-obsidian.com/application/`. Check documentation for methods of using this in
  your application.
- Allowing users to customize their apps by adding additional optional configurations, `mycontrol` & `mymodule`.
- Added the ability to overwrite the configurations stored in  `Libraries/Configs` by passing an array to `module()`.
- Additional routing info will be passed to Control class into `$this->routes` to be used by an Controls that you
  create, this functionality will be included as a part of the CoreRouting module.
- Added the ability to modify how the routing runs by making sure it calls a `start()` method if exists.

#### Version 1.2.3
- Replaced Facebook Enhanced with Facebook Ignited `Version 1.3.1`, `not-ignited` branch.
- Added a check for isset to input module, so that we can see if the key is existant.

#### Version 1.2.2
- Upgraded Facebook Enhanced from `Version 1.0.3` to `Version 1.2.0` (with Facebook PHP SDK v3.2.1).
- Deprecated core_mysql class, will no longer contribute to it.
- Views can now use $core from within views, instead of needing to use $this.
- Core System will now throw exceptions to the application if there are errors during
  the calling of methods, please catch the exceptions.

#### Version 1.2.1
- Removed a lot of the useless MySQL Extension functions that plainly aren't up to par with what I wanted.
- Removed the MySQLi class.
- Added the PDO Class to the system.
- Added the `core_pdo::last_id()` method (grabs the last insert id) to MySQL Extension and PDO Classes.

#### Version 1.2.0
- Added the core_benchmark class to use with Obsidian Moon Engine (advocaite).

#### Version 1.1.0
- Reformatted the framework to no longer require the Constants it previously needed.

#### Version 1.0.1
- Added the ability to import third party modules and classes.