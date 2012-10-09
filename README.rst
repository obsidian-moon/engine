=========================================
Obsidian Moon Engine v1.2.2 Documentation
=========================================
This is a project that I have worked on for several months after being inspired by CodeIgniter.
After setting up the initial steps of the system I am opening the project up for open source.
Feel free to contribute and peer review my work, please not that there are a few pieces that are 
based on CodeIgniter that need to be worked on.

-Necromnius aka Rev. Alfonso E Martinez, III


Instructions for Installation
=============================

You will need a few things for this to work correctly: 
	
1) This code 
2) Hosting with PHP support

You will need to place the ``Obsidian-Moon-Engine`` folder in the ``/home/user/`` directory also known as ``~/``

You can do so by doing: ``cd ~/`` followed by ``git clone git://github.com/deth4uall/Obsidian-Moon-Engine.git`` which will clone the latest master version 
into that the ``Obsidian-Moon-Engine`` directory.

Create a folder that will hold the contents of application folder, and ensure that it is a document root for better results.
The sub folder feature needs to be worked on.

You can initiate the Obsidian Moon Engine in your index and add basic functionality with the following:

	::
	
		session_start();
		// Get the URI from the system explode it into an array, grab the control and then slice the rest 
		// into a variable called $params. 
		$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
		$control = $uri[0];
		$params = array_slice($uri, 1);
		// Include and instantiate the class
		include('/home/user/Obsidian-Moon-Engine/ObsidianMoonCore.php');
		$conf = array(
			'core' => '/home/user/Obsidian-Moon-Engine/',
			'libs' => dirname(__FILE__) . '/libraries/',
			'base' => dirname(__FILE__) . '/',
			'defcon' => 'main', //default control
			'publ' => $_SERVER['HTTP_HOST'],
			'modules' => array(
				'input'
			) // Modules lists all of the classes you want to load automatically
		);
		// All values are set as $core->conf_**** by their key value
		$core = new ObsidianMoonCore($conf);
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
		|   |-- classes/         * Holds all of your classes
		|   |-- configs/         * This holds the configs for your classes
		|   |   |-- core/        * Core class configs (eg. core_mysql)
		|	|   |-- third_party/ * Third Party configs (eg. Smarty)
		|   |-- control/         * All of the controllers for your app go in here
		|   |-- third_party/     * Any classes that are not maintained by you can be placed here and called
		|   |-- views/           * HTML views for you to insert data into
		|-- static/              * I use a static fold to hold all my assets
		|-- .htaccess
		|-- index.php

Instructions for Using Obsidian Moon
====================================

There are two functions that you really need to know. The first of all is the ``classes()`` method. Let's start off by creating a basic class that will be used.

	::
		
		<?php
		// Location: /home/user/public_html/libraries/classes/basic_class.php
		class basic_class {
			var $core; // We need this so that we can access the core from within the class as $this->core
			
			function __construct() { }
			
			function my_method() {
				return "Hello World!";
			}

			function om_start() {
				// If you need to do something after the construct but need $this->core run it here
				// If this method exists it will be automatically run
			}
		}

This class will now be accessible from within your controller to be started. Let's go over that a bit so that you know how you can start up a class.

	::
		
		<?php
		// Location: /home/user/public_html/libraries/control/main.php
		$core->classes('basic_class','basic'); 
		// This allows you to pull up the ../classes/basic_class.php and assign it to 'basic'
		$core->basic->my_method(); 
		// You are then able to call it from core
		
		// Another thing that you can do is use the third_party folder, since some of you like to use smarty which has the class name as 'Smarty'
		$core->classes('third_party/Smarty/Smarty.class', 'smarty', 'Smarty'); 
		// The third option allows you to declare what the class name is from the file
		$core->smarty->display();
		
		// Finally, if you need to declare several files in one shot you can pass an array to the first parameter and it will handle it:
		$core->classes(array(
			'basic_class',
			'core/core_input'=>'input',
			'third_party/Smarty/Smarty.class'=>array('smarty','Smarty') 
		);
		// The above is the equivalent of:
		$core->classes('basic_class'); 
		$core->classes('core/core_input','input'); 
		$core->classes('third_party/Smarty/Smarty.class','smarty','Smarty');

		// Summary:
		// classes('location/name','name_of_var_to_set','othername');

You will need to keep in mind the following exceptions to the first parameter:

- starting with ``core/`` will use ``/home/user/Obsidian-Moon-Engine/classes/`` as base.
- starting with ``third_party/`` will use ``/home/user/public_html/libraries/third_party/``
- don't use the above two keywords otherwise you won't find the classes you defined, anything else pulls from ``/home/user/public_html/libraries/classes/``
- You can use sub-directories eg. ``main/main_index`` for ``/home/user/public_html/libraries/classes/main/main_index.php``

The second method is the ``views()`` method, which is quite simple compared to the ``classes()`` method. First off lets create a simple view

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
		// Get the basic_class added so that we can use it to grab info and drop into a view.
		$core->classes('basic_class','basic');
		
		// Then we will take the my_method() and get the returned value and assign to an array.
		$data['test_value'] = $core->basic->my_method(); // Returns Hello World!
		
		// Then we will send it into a view and it will be appended to $core->output
		$core->views('simple_view',$data); // $data must always be an array

		// However if you wanted to return the value of the view to a variable you can do so by:
		$my_var = $core->views('simple_view',$data,true);

		// On occasion you may come across an issue where you don't need to have a view but want to 
		// display the data variable for example handling AJAX. This will assign it straight to $core->output
		$core->views(null,$data);
		

		

Summary of Obsidian Moon
========================

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to add modules, tweak the code and 
add features I have not thought of, however please give credit by placing "Powered by Obsidian Moon" if you do use the engine. And if you make code that 
improves on what I have now, feel free to share back! Thanks and Enjoy!
