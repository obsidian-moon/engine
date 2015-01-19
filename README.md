Obsidian Moon Engine
====================

This is a project that I have worked on for several months after being originally inspired
by CodeIgniter. After setting up the initial steps of the system I am opening the
project up for open source. Feel free to contribute and peer review my work, please
not that there are a few pieces that are based on CodeIgniter that need to be worked on.

Alfonso E Martinez, III of Dark Prospect Games, LLC

<a name="installing"></a>
## Installing Obsidian Moon Engine

Since Obsidian Moon Engine uses [Composer](http://getcomposer.org) you will need to install it before you can run the
code with it. If you do not already have Composer you can install it by doing the following from your command line:

```bash
curl -sS https://getcomposer.org/installer | php
```

Once you have installed Composer you will then be able to install it automatically and configure the autoloader to load
all of your application's files by entering the following into a `composer.json` file:

```json
{
  "require": {
    "dark-prospect-games/obsidian-moon-engine": "~1.4.0"
  },
  "autoload": {
    "psr-4": {
      "MyCompanyNamespace\\MyApplication\\": "src/"
    }
  }
}
```

After editing the file, you can simply run the following command to use the Composer file you installed:

```bash
php composer.phar install
```

If you use apache you will be able to start setting up the routing by using the following in the app's root folder:

```
# Enabling the mod_rewrite module in this folder
RewriteEngine On
Options +FollowSymLinks

# Protecting access to secure locations
RewriteCond %{REQUEST_URI} ^src.*
RewriteRule ^(.*)$ /index.php?/$1 [L]

# Redirects invalid locations to index
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
```

<a name="base-methods"></a>
## Overview of the Base Methods

Within the Obsidian Moon Engine there are a few functions that you will need to keep in mind when using using the framework.
The first of all is that the system uses a path routing system that you will need to declare in the configurations. The files
used to manage the flow of application's called Controls. In order to provide an ease of use upon installation, Obsidian Moon
Engine comes with a default routing module 
that you use or extend and/or overwrite.

Within the Control you will be able to load modules (`Core::module()`) and views (`Core::view()`) as well as handle any errors that
occur during the process of your application's life cycle.

<a name="latest-changes"></a>
## Latest Changes

<a name="latest-changes.features"></a>
### Features

- Found extra information regarding PHPDocs so I include those changes as well.
- Removed `.htaccess` and placed contents in `README.md` under installation information.
- Removed the unused dependencies in `require-dev`
- Renamed the `Changelog.md` to `CHANGELOG.md`
- Added a core method named `data()` that will allow users to add view data that is available to all views.

<a name="latest-changes.breaking-changes"></a>
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

[Complete List of Changes](Changelog.md)


<a name="summary"></a>
## Summary of Obsidian Moon Engine

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to
submit modules for addition into the core, tweak the code to suite your needs and add any features I have not thought
of yet. If you do use this framework we would appreciate you any credit given and would like if you could like back to
this page. Additionally if you happen to write code that improves on what I have already created, please feel free to
share back! We will appreciate any assistance! Thanks and Enjoy!

Regards,
Alfonso E Martinez, III
Dark Prospect Games, LLC
