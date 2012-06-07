=========================================
Obsidian Moon Engine v1.1.0 Documentation
=========================================
This is a project that I have worked on for several months after being inspired by CodeIgniter.
After setting up the initial steps of the system I am opening the project up for open source.
Feel free to contribute and peer review my work, please not that there are a few pieces that are based on CodeIgniter that need to be worked on.

-deth4uall aka Rev. Alfonso E Martinez, III


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
			'publ' => $_SERVER['HTTP_HOST'],
			'modules' => array(
				'input'
			)
		);
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
		|   |-- classes/		* Holds all of your classes
		|   |-- configs/		* This holds the configs for your classes
		|   |   |-- core/		* Core class configs (eg. core_mysql)
		|   |-- control/		* All of the controllers for your app go in here
		|   |-- third_party/	* Any classes that are not maintained by you can be placed here and called
		|   |-- views/			* HTML views for you to insert data into
		|-- static/				* I use a static fold to hold all my assets
		|-- .htaccess
		|-- index.php

Instructions for Using Obsidian Moon
====================================

There are two functions that you really ne

Summary of Obsidian Moon
========================

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to add modules, tweak the code and 
add features I have not thought of, however please give credit by placing "Powered by Obsidian Moon" if you do use the engine. And if you make code that 
improves on what I have now, feel free to share back! Thanks and Enjoy!
