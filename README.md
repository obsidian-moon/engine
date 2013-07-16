## Obsidian Moon Engine v1.3.0 Documentation
This is a project that I have worked on for several months after being inspired
by CodeIgniter. After setting up the initial steps of the system I am opening the
project up for open source. Feel free to contribute and peer review my work, please
not that there are a few pieces that are based on CodeIgniter that need to be worked on.

Alfonso E Martinez, III of Dark Prospect Games, LLC

### Installing Obsidian Moon Engine

[Installing Obsidian Moon Engine on Wiki](https://github.com/DarkProspectGames/ObsidianMoonEngine/wiki/Installing-Obsidian-Moon-Engine)

You will need a few things for this to work correctly:

1. Obsidian Moon Engine
2. Hosting with PHP 5.3+
3. Shell access with Git (or FTP access instead)

If these are satisfied you will be able to install the Obsidian Moon Engine to `~/` by
following the following the following instructions:

```bash
cd ~/
git clone git://github.com/DarkProspectGames/ObsidianMoonEngine.git
```

### Setting Up Your File Structure

[Setting Up Your File Structure on Wiki](https://github.com/DarkProspectGames/ObsidianMoonEngine/wiki/Setting-Up-Your-File-Structure)

Once you have installed the Obsidian Moon Engine you will want to set up your working
directory like such for the framework to see all of the files correctly, however this
is just the suggested layout as I will explain shortly:

```
/
|-- Libraries/
|   |-- Modules/   * Holds all of your modules
|   |-- Configs/   * This holds the configs for your modules
|   |   |-- Core/  * Core class configs (eg. core_mysql.php matches $core_path/Modules/core_mysql.php)
|   |-- Controls/  * All of the controllers for your app go in here
|   |-- Views/     * HTML views for you to insert data into
|-- static/        * I use a static fold to hold all my assets
|-- .htaccess
|-- index.php
```

Once you setup the file structure we will need to make sure that we also create an
`.htaccess` to the system with the following rules, so that we ensure the proper path:

```apache
RewriteEngine On
Options +FollowSymLinks
RewriteBase /
# If using a subdirectory use as below instead
RewriteBase /application

# Remove the ability to access Libraries folder
RewriteCond %{REQUEST_URI} ^Libraries.*
RewriteRule ^(.*)$ /index.php?/$1 [L]

# Checks to see if the user is attempting to access a valid file,
# such as an image or css document, if this isn't true it sends the
# request to index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?/$1 [L]
```

### Instantiating the Obsidian Moon Engine

[Instantiating the Obsidian Moon Engine on Wiki](https://github.com/DarkProspectGames/ObsidianMoonEngine/wiki/Instantiating-the-Obsidian-Moon-Engine)

Once you have the file structure and `.htaccess` setup correctly, you will then be able
to initiate the Obsidian Moon Engine from the `index.php` in the application root directory
and add the basic functionality with the following:

```php
<?php
// If you need to add to the include path and create a session.
include '/home/user/ObsidianMoonEngine/Core.php';
session_start();

// Include and instantiate the class
use \ObsidianMoonEngine\Core;
$conf = array(
    'defcon'    => 'Main',
    'modules'   => array('CoreInput'),
);
try {
    $core = new Core($conf);
    $core->routing();
} catch (Exception $e) {
    echo 'There was an error initializing the system: '.$e->getMessage();
}
// The Core will echo out the output buffer after the class finishes
```

### Overview of the Base Methods

Within the Obsidian Moon Engine there are a few functions that you will need to keep in mind when using using the framework.
The first of all is that the system uses a path routing system that you will need to declare in the configurations. The files
used to manage the flow of application's called Controls. In order to provide an ease of use upon installation, Obsidian Moon
Engine comes with a default routing module ([CoreRouting](https://github.com/DarkProspectGames/ObsidianMoonEngine/wiki/Module-CoreRouting))
that you use or extend and/or overwrite.

Within the Control you will be able to load modules (`Core::module()`) and views (`Core::view()`) as well as handle any errors that
occur during the process of your application's life cycle.

### Summary of Obsidian Moon

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to
submit modules for addition into the core, tweak the code to suite your needs and add any features I have not thought of yet.
If you do use this framework we would appreciate you any credit given and would like if you could like back to this page. Additionally if you
happen to write code that improves on what I have already created, please feel free to share back! We will appreciate any assistance! Thanks and Enjoy!

Dark Prospect Games, LLC
