## Obsidian Moon Engine
This is a project that I have worked on for several months after being originally inspired
by CodeIgniter. After setting up the initial steps of the system I am opening the
project up for open source. Feel free to contribute and peer review my work, please
not that there are a few pieces that are based on CodeIgniter that need to be worked on.

Alfonso E Martinez, III of Dark Prospect Games, LLC

### Installing Obsidian Moon Engine

Using [Composer](http://getcomposer.org) is the recommended way to install the Obsidian Moon Engine.
In order to use the Obsidian Moon Engin through Composer, you enter the following into your `composer.json` file:

```json
{
    "require": {
        "dark-prospect-games/obsidian-moon-engine": "1.3.*"
    }
}
```

If you do not have Composer you can install it by doing the following from your command line:

```bash
curl -sS https://getcomposer.org/installer | php
```

In order to install the project's dependencies, you will need to run an install.

```bash
php composer.phar install
```

### Overview of the Base Methods

Within the Obsidian Moon Engine there are a few functions that you will need to keep in mind when using using the framework.
The first of all is that the system uses a path routing system that you will need to declare in the configurations. The files
used to manage the flow of application's called Controls. In order to provide an ease of use upon installation, Obsidian Moon
Engine comes with a default routing module ([CoreRouting]( https://gitlab.com/dark-prospect-games/obsidian-moon-engine//wiki/Module-CoreRouting))
that you use or extend and/or overwrite.

Within the Control you will be able to load modules (`Core::module()`) and views (`Core::view()`) as well as handle any errors that
occur during the process of your application's life cycle.

### Summary of Obsidian Moon

You will find that the Obsidian Moon Engine is 100% modular and will expand as you build code into it. Feel free to
submit modules for addition into the core, tweak the code to suite your needs and add any features I have not thought of yet.
If you do use this framework we would appreciate you any credit given and would like if you could like back to this page. Additionally if you
happen to write code that improves on what I have already created, please feel free to share back! We will appreciate any assistance! Thanks and Enjoy!

Dark Prospect Games, LLC
