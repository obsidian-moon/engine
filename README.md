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
    error_log('Error on OME Construct: '.$e->getMessage());
    echo 'There was an error initializing the system, please try again!';
    exit;
}
// The Core will echo out the output buffer after the class finishes
```

### Overview of the Base Methods

Within the Obsidian Moon Engine there are a few functions that you will need to keep in mind
when using using the framework. The first of all is that the system uses a path routing system
that you will need to declare in the configurations. The files used to manage the flow of
application's called ControlsIn order to provide an
ease of use upon installation, Obsidian Moon Engine comes with a default routing module
([CoreRouting](https://github.com/DarkProspectGames/ObsidianMoonEngine/wiki/Module-CoreRouting))
that you use or extend and/or overwrite.

Within the Control you will be able to load modules and views as well as handle any errors that
occur during the process of your application's life cycle.

### Deprecated Documentation

There are two functions that you really need to know. The first of all is the `module()`
method. Let's start off by creating a basic module that will be used by the Core class:

```php
<?php
// Location: /home/user/public_html/Libraries/Modules/BasicModule.php
namespace ObsidianMoonEngine;
class BasicModule extends Module
{

    /**
     * The constructor for the Basic Module
     *
     * If you need to create your own custom constructor you will need to inherit the parents
     * attributes so that you do not lose functionality or have errors occur.
     *
     * @param Core  $core    Referencing the Obsidian Moon Engine core class.
     * @param mixed $configs Optional configurations that will be automatically
     *                       passed to the Module.
     *
     * @return Module
     */
    public function __construct(Core $core, $configs = null)
    {
        /**
         * This is a custom constructor: $core and $configs are handled
         * by parent and assigned to $this->core and $this->configs.
         */
        parent::__construct($core, $configs);
        // Custom handling in the constructor.
        if ($this->configs['custom_config'] !== null) {
            $this->customConstructMethod();
        }
    }

    /**
     * Custom Construct Method
     *
     * We call this in the constructor if the key 'custom_config' is assigned to
     * $this->configs and has a value that is not null.
     *
     * @return void
     */
    protected function customConstructMethod()
    {
        // Custom handling example.
        echo "This was echoed in constructor!";
    }

    /**
     * My Method
     *
     * We can call at any time with the framework and it will return a string
     * with the value of "Hello World!".
     *
     * @return string
     */
    public function myMethod()
    {
        return "Hello World!";
    }

    /**
     * If you need to do something after the construct but need $this->core run
     * it here. If this method exists it will be automatically run.
     *
     * This function will be called if you need to have any tasks happen after the
     * initialization of the class, but before the rest of the code.
     *
     * @deprecated 1.3.0 Finding a better way to handle this.
     *
     * @return void
     */
    public function start()
    {
    }
}
```

This module will now be accessible from within your controller to be started. Let's go over that a bit so that
you know how you can start up and use a module:

```php
<?php
// Location: /home/user/public_html/Libraries/Controls/Main.php
class ControlMain extends Control
{
    public function __construct()
    {
        parent::__construct();

        $core->module(array('BasicModule'));
        // By using only a value the system will automatically assume you don't want to
        // change the name of the module being loaded and will use the standard class
        // name and allow you to call it from $core like such:
        $core->basic_module->myMethod();
    }

    public function index()
    {
        // This called from the URI '/main/'

        $core->module(array('BasicModule' => 'basic'));
        // If you do not want to use the same class name you can create an alias in the system by assigning the class
        // to the key and the alias to a value. This will then allow you to pull up the Modules/BasicModule.php and
        // assign it to '$core->basic' which you are then able to call as follows, assuming it is not previously set:
        $this->core->basic->myMethod();

        // Another thing that you can do is use subfolders to organize all of your module, and since some of you like
        // to use smarty which does not follow the OME standards has a class name of 'Smarty'. By making the value an
        // array and making the second value in the array the name of the class you can call third party modules and
        // classes like follows. Notice the folders being included in the key to access it:
        $this->core->module(array('third_party/Smarty/Smarty.class' => array('smarty', 'Smarty')));
        $this->core->smarty->display();
    }

    public function aboutsite()
    {
        // This is called when URI is '/main/aboutsite/'

        // Occasionally you may need to overwrite the default configuration that you previously declared in the
        // configurations file located in 'Libraries/Configs/` by adding an additional array to the third value
        // as follows. This will allow you to dynamicly create classes with configurations that differ from default.
        $database_overwrite = array(
                               'host' => 'remotehost',
                               'name' => 'data_base_2',
                               'user' => 'userName2',
                               'pass' => 'password2',
                              );
        $this->core->module(array('CorePDO' => array('db', null, $database_overwrite)));
    }

    /**
     * This is called when the class is created.
     *
     * @return void
     */
    public function start()
    {
        // This is called after it is initialized.

        // Finally, if you need to declare several files in one shot you can just add to the array and pass multiple
        // keys and array values as follows to the module method and it will handle adding them all automatically for you:
        $this->core->module(array(
                             'BasicModule',
                             'CoreInput'                       => 'input',
                             'third_party/Smarty/Smarty.class' => array('smarty', 'Smarty'),
                             'CorePDO'                         => array('db', null, $database_overwrite),
                            ));
    }

}
// Summary:
// Core::module(array('Location/Name' => array('instance_variable', 'third_party_class_name', array('config1'=>'value1'))));
```

You will need to keep in mind the following details for the first parameter or array key of the details:

- Starting with `Core` will use `/home/user/ObsidianMoonEngine/Modules/` as base, do not try to use a path afterwards
  because it will try to look in Core modules. Future revisions will have this rectified. All core modules don't currently
  use any paths so the use of them is unneeded for Core modules.
- If the path/file are not prefixed for Core the Core class will try to match a path and module name from within the application's
  module folder, located in the `/home/user/public_html/Libraries/Modules/` folder for these examples.
- You can use subdirectories to access files within your app's Modules folder structure, for example `Main/MainIndex`
  will find `/home/user/public_html/Libraries/Modules/Main/MainIndex.php` and will call the `MainIndex` module class name
  from the file and will additionally attempt to check for the existance of a config file located in the applications Configs folder
  located at `/home/user/public_html/Libraries/Configs/Main/MainIndex.php` for these examples.

The second method is as quite important as the previous one. The `view()` method, which is quite simple compared
to the `module()` method, pulls up views with html that display the result of the data processed from the modules.
Below I have created an example of a simple view that we will use to show to the user after we calculate the resulting data,
Note that you can of course use basic operators if you wish like the 'if', 'loop', etc:

```php
<?php
// Location: /home/user/public_html/Libraries/Views/SimpleView.php
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test View</title>
    </head>
    <body>
        <?=$test_value?>
    </body>
</html>
```

In order to handle both the modules and views we have we will go back to the main controller and use it
again to pull the views into the browser for the user. Depending on how you use it, it will handle the results
differently as you will see below:

```php
<?php
// Location: /home/user/public_html/Libraries/Controls/Main.php

// Get the BasicModule added so that we can use it to grab data and insert it into a view. After that we will
// take the myMethod() and get the returned value of 'Hello World!' and assign it to an array with the key of
// of 'test_value' since that is the variable we are going to be replacing.:
$this->core->module(array('BasicModule' => 'basic'));
$this->data['test_value'] = $this->core->basic->myMethod();

// After we have assigned data to an array with the appropriate keys we will then send it into a view will will
// be appended to the Core class's internal buffer. Please note though that variable you pass to 'view()' must
// always be an array due to how it handles the data we give it to populate into the view.
$this->core->view('SimpleView', $this->data);

// Note: Like the 'module()' method you are able to use subfolders in the 'Libraries/Views/' folder.

// If you ever needed to have the value of the view returned to a variable you can do so by passing a 'true' to
// the third parameter of the 'view()' method, which instead of adding to buffer will allow you to save it to
// a variable for later use:
$this->saved_view['content'] = $this->core->view('SimpleView', $this->data, true);

// If you ever come across an issue where you don't need to pass anything to a view but might want to display the
// data variable, for example handling AJAX where you only wanted to echo out a JSON response, you can give the
// first parameter a null value. This will skip looking for a view assign it straight to Core class's out buffer
// and release it so that will shown. As you can see below I only want to give a JSON response:
$this->response = json_encode(
                array('error' => 'We were unable to find your account, please check your username and try again!');
            );
$this->core->view(null, $this->response);
```

### Summary of Obsidian Moon

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to
submit modules for addition into the core, tweak the code to suite your needs and add any features I have not thought of yet.
If you do use this framework we would appreciate you giving credit by placing a link to this page with "Powered by Obsidian
Moon Engine" in the footer of the app use the engine with. Additionally if you happen to write code that improves on what I
have already added before now, please feel free to share back! We will appreciate any assistance! Thanks and Enjoy!

Dark Prospect Games, LLC
