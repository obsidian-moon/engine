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

You can initiate the Obsidian Moon Engine with the following:

	::
	
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

Instructions for Using Obsidian Moon
====================================

You will find that the Obsidian Moon engine is 100% modular and will expand as you build code into it. Feel free to add modules, tweak the code and 
add features I have not thought of, however please give credit by placing "Powered by Obsidian Moon" if you do use the engine. And if you make code that 
improves on what I have now, feel free to share back! Thanks and Enjoy!
