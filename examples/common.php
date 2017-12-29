<?php
/**
 * Example common file
 *
 * @global \DarkProspectGames\ObsidianMoonEngine\Core $core   Core object we will use.
 */
include __DIR__ . '/config/environment.php';
session_start();
include __DIR__ . '/../vendor/autoload.php'; // Example should work with parent directories

use \DarkProspectGames\ObsidianMoonEngine\Core;
use \DarkProspectGames\ObsidianMoonEngine\Modules\Input as CoreInput;

try {
	$core = new Core([
		'modules' => [
			'input' => new CoreInput()
		]
	]);
} catch (Exception $e) {
	echo $e->getMessage();
}