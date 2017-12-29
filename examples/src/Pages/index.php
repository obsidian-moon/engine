<?php
/**
 * A basis core index page to expand on
 */
$core->module('example', new \DarkProspectGames\ExampleApp\Modules\ExampleModule());
$content = $core->view('index', ['greeting' => $core->example->sayHello('World')], true);
$core->view('layout/layout', ['content' => $content]);