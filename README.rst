=========================================
Obsidian Moon Engine v1.3.0 Documentation
=========================================
This is a project that I have worked on for several months after being inspired by CodeIgniter.
After setting up the initial steps of the system I am opening the project up for open source.
Feel free to contribute and peer review my work, please not that there are a few pieces that are
based on CodeIgniter that need to be worked on.

-deth4uall aka Alfonso E Martinez, III


Instructions for Installation
=============================

You will need a few things for this to work correctly:

1) This code
2) Hosting with PHP support

You will need to place the ``ObsidianMoonEngine`` folder in the ``/home/user/`` directory also known as ``~/``

You can do so by doing: ``cd ~/`` followed by ``git clone git://github.com/DarkProspectGames/ObsidianMoonEngine.git`` which will clone the latest master version
into that the ``ObsidianMoonEngine`` directory.

Create a folder that will hold the contents of application folder, and ensure that it is a document root for better results.
The sub folder feature needs to be worked on.

You can initiate the Obsidian Moon Engine in your index and add basic functionality with the following:

    ::

        // If you need to add to the include path.
        $core_path = '/home/user/ObsidianMoonEngine/';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        session_start();

        // Get the URI from the system explode it into an array, grab the control and then slice the rest
        // into a variable called $params.
        $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $control = $uri[0];
        $params = array_slice($uri, 1);

        // Include and instantiate the class
        use \ObsidianMoonEngine\Core;
        $conf = array(
            'defcon' => 'main',
            // Default control that will be shown.
            'modules' => array('input'),
            // Modules lists all of the classes you want to load automatically
        );
        $core = Core::start($conf);
        // All values are set as $core->conf_**** by their key value

        // Handle what control is called
        if ($control == "") {
            // If a control isn't called use the default
            include("{$core->conf_libs}control/{$core->conf_defcon}.php");
        } elseif (!file_exists("{$core->conf_libs}control/{$control}.php")) {
            // Use default if the called control is not available
            include("{$core->conf_libs}control/{$core->conf_defcon}.php");
        } else {
            // If existant then use the control called
            include("{$core->conf_libs}control/{$control}.php");
        }

        // Finally let's echo out the output!
        echo $core->output;

After that we will need to make sure that we also add a .htaccess to the system as well

    ::

        RewriteEngine On
        Options +FollowSymLinks
        RewriteBase /

        # Remove the ability to access libraries folder
        RewriteCond %{REQUEST_URI} ^libraries.*
        RewriteRule ^(.*)$ /index.php?/$1 [L]

        #Checks to see if the user is attempting to access a valid file,
        #such as an image or css document, if this isn't true it sends the
        #request to index.php
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php?/$1 [L]

Once you have those two files squared away you will want to set up your working directory like such for the sanity of the framework:

    ::

        /
        |-- libraries/
        |   |-- modules/         * Holds all of your modules
        |   |   |-- third_party/ * Any classes that are not maintained by you can be placed here and called
        |   |-- configs/         * This holds the configs for your modules
        |   |   |-- core/        * Core class configs (eg. core_mysql)
        |   |   |-- third_party/ * Third Party configs (eg. Smarty)
        |   |-- control/         * All of the controllers for your app go in here
        |   |-- views/           * HTML views for you to insert data into
        |-- static/              * I use a static fold to hold all my assets
        |-- .htaccess
        |-- index.php

Instructions for Using Obsidian Moon
====================================

There are two functions that you really need to know. The first of all is the ``module()`` method. Let's start off by creating a basic module that will be used.

    ::

        <?php
        // Location: /home/user/public_html/libraries/modules/basic_module.php
        namespace ObsidianMoonEngine\Modules;
        use ObsidianMoonEngine\Core, ObsidianMoonEngine\Module, ObsidianMoonEngine\Control;
        class basic_module extends Module
        {
            /**
             * @var Core This is handled by the parent 'Module' and thus does not need to
             *           be redeclared.
             */
            protected $core;

            /**
             * @var mixed $core This will be used to handle by the parent class, you do not
             *                  need to declare it in your Module when you extend core Module.
             */
            protected $configs;

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
                 * This is a custom constructor: $core and $configs are handled by parent
                 * and assigned to $this->core and $this->configs.
                 */
                parent::__construct($core, $configs);
                // Custom handling in the constructor.
                if ($this->configs['custom_config'] !== null) {
                    $this->custom_construct_method();
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
            protected function custom_construct_method()
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
            public function my_method()
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

This module will now be accessible from within your controller to be started. Let's go over that a bit so that you know how you can start up a module.

    ::

        <?php
        // Location: /home/user/public_html/libraries/control/main.php
        $core->module(array('basic_module'=>'basic'));
        // This allows you to pull up the ../modules/basic_module.php and assign it to 'basic'
        $core->basic->my_method();
        // You are then able to call it from core

        // Another thing that you can do is use the third_party folder, since some of you like to use smarty which has the class name as 'Smarty'
        $core->module('third_party/Smarty/Smarty.class', 'smarty', 'Smarty');
        // The third option allows you to declare what the module name is from the file
        $core->smarty->display();

        // Finally, if you need to declare several files in one shot you can pass an array to the first parameter and it will handle it:
        $core->module(array(
            'basic_module',
            'core_input'=>'input',
            'third_party/Smarty/Smarty.class'=>array('smarty','Smarty')
        );
        // The above is the equivalent of:
        $core->module('basic_module');
        $core->module('core_input','input');
        $core->module('third_party/Smarty/Smarty.class','smarty','Smarty');

        // Summary:
        // module('location/name','name_of_var_to_set','othername');

You will need to keep in mind the following exceptions to the first parameter:

- starting with ``core_`` will use ``/home/user/ObsidianMoonEngine/modules/`` as base.
- starting with ``third_party/`` will use ``/home/user/public_html/libraries/third_party/``
- don't use the above two keywords otherwise you won't find the module you defined, anything else pulls from ``/home/user/public_html/libraries/modules/``
- You can use sub-directories eg. ``main/main_index`` for ``/home/user/public_html/libraries/modules/main/main_index.php``

The second method is the ``view()`` method, which is quite simple compared to the ``module()`` method. First off lets create a simple view

    ::

        <?php
        // Location: /home/user/public_html/libraries/views/simple_view.php
        ?>
        <html>
            <body><?=$test_value?></body>
        </html>

After that we will go back to the main controller

    ::

        <?php
        // Location: /home/user/public_html/libraries/control/main.php
        // Get the basic_module added so that we can use it to grab info and drop into a view.
        $core->module('basic_module','basic');

        // Then we will take the my_method() and get the returned value and assign to an array.
        $data['test_value'] = $core->basic->my_method(); // Returns Hello World!

        // Then we will send it into a view and it will be appended to $core->output
        $core->view('simple_view',$data); // $data must always be an array

        // However if you wanted to return the value of the view to a variable you can do so by:
        $my_var = $core->view('simple_view',$data,true);

        // On occasion you may come across an issue where you don't need to have a view but want to
        // display the data variable for example handling AJAX. This will assign it straight to $core->output
        $core->view(null,$data);


Summary of Obsidian Moon
========================

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to add modules, tweak the code and
add features I have not thought of, however please give credit by placing "Powered by Obsidian Moon Engine" if you do use the engine.
Additionally if you write code that improves on what I have now, feel free to share back! Thanks and Enjoy!
