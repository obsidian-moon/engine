Obsidian Moon Engine
====================

[![Floobits Status](https://floobits.com/opensaurusrex/obsidian-moon-engine.svg)](https://floobits.com/opensaurusrex/obsidian-moon-engine/redirect)

This is a project that I have worked on for several years after wanting a completely modular framework. I am aiming for 
lightweight and able to include any modules from other applications, etc.

<a name="installing"></a>
## Installing Obsidian Moon Engine

Since Obsidian Moon Engine uses [Composer](http://getcomposer.org) you will need to install it before you can run the
code with it. Once you have installed Composer you will then be able to install it by running the following command:

```bash
composer create-project obsidian-moon/framework
```

Or, if you want to use the Obsidian Moon Engine in a previously made project, you can instead run:

```bash
composer require obsidian-moon/engine
``` 

Once installed you can make your application's files by entering the following into a `composer.json` file:

```json
{
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


<a name="file-structure"></a>
## File Structure

You can now run `composer create-project obsidian-moon-development/obsidian-moon-framework` to install a new install with the
following file structure:

```
.
|-- config/             // For the presession modifications used by OME
|   |-- environment.php // Modifies system values if needed, before the session is started
|-- logs/               // Location for Monolog to place the .log files.
|-- node_modules/       // If you use something like webpack, you would .gitignore this folder.
|-- public/             // Contains all the files that are available to user, eg. js, css, images, etc.
|   |-- .htaccess       // Look in examples for how to best set this
|   |-- index.php       // The primary entry point to your application.
|   |-- ...
|-- src/                // Required library directory used by OME
|   |-- Controllers/    // All Controllers go in here.
|   |-- Modules/        // Required, contains modules used by the app
|   |-- Pages/          // Not required but I use it to run without Routing for now, while I work on improving it
|   |-- Views/          // Required for any and all views used by OME
|   |-- ...             // You can access any folder in `src` by using `$core->conf_libs . '/dirname'`;
|-- vendor/             // Composer files needed for application, you can gitignore this
|-- common.php
|-- composer.json
|-- ...

```

If you use apache you will be able to start setting up the routing by using the following in an `.htaccess` file in the 
app's `public` folder:

```
# Enabling the mod_rewrite module in this folder
RewriteEngine On
Options -Indexes

# Redirects invalid locations to index
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
```

<a name="base-methods"></a>
## Overview of the Base Methods

Within the Obsidian Moon Engine there are a few functions that you will need to keep in mind when using using the 
framework. The first of all is that the system uses a path routing system that you will need to declare in the 
configurations. The files used to manage the flow of application's called Controls. In order to provide an ease of use 
upon installation, Obsidian Moon Engine comes with a default routing module that you use or extend and/or overwrite.

Within the Control you will be able to load modules (`Core::module()`) and views (`Core::view()`) as well as handle any 
errors that occur during the process of your application's life cycle.

<a name="latest-changes.planned"></a>
## Planned Future Inclusions

- Rewriting the `DarkProspectGames\ObsidianMoonEngine\Modules\Routing` class and making it so that it works better.

[Complete List of Changes](CHANGELOG.md)

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
