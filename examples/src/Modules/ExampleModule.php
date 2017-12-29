<?php
/**
 * An example of what you can do to extend with modules
 */
namespace DarkProspectGames\ExampleApp\Modules;

use DarkProspectGames\ObsidianMoonEngine\AbstractModule;

/**
 * Class ExampleModule
 *
 * @package DarkProspectGames\ExampleApp
 */
class ExampleModule extends AbstractModule
{
	/**
	 * @param $person
	 *
	 * @return string
	 */
	public function sayHello($person): string
	{
		return 'Hello, ' . $person . '!';
	}
}