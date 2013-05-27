## Obsidian Moon Engine Change Log

#### Version 1.3.0
- The framework will now only be able to be called from a singleton using `Core::start()`
  which will use a single instance.
- The Obsidian Moon Engine will now use the `ObsidianMoonEngine` namespace for all of it's
  components, and will be required in all of your applications components.
- Removed `core_mysql` module from the framework with the deprecation of MySQL class in PHP 5.5.
  Please, use the `core_pdo` module instead, more optimizations will be introduced at a later time.
- Modules and Controls will not extend a superclass designed to provide a skeleton for each.
- Routing is now handled by a routing module which we will now have to defined in the
  configurations on creations.
- Added the ability to use subdirectories as the base of the application, for example:
  `http://my-obsidian.com/application/`. Check documentation for methods of using this in
  your application.

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