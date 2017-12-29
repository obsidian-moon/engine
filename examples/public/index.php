<?php
/**
 * This is an example of how I work on my application, it is a work in progress but it works.
 * I will work to get it running with Routing soon.
 */
include __DIR__ . '/../common.php';

$filter = ['/\?.*$/i'];
if (property_exists($core, 'conf_subdir')) {
	$filter[] = "/{$core->conf_subdir}/i";
}

$uri_raw = str_replace('.php', '', $_SERVER['REQUEST_URI']);
$uri = explode('/', trim(preg_replace($filter, '', $uri_raw), '/'));
if (empty($uri[0]))
{
	$str = $core->input->get('str', 'isset') ? $core->input->get('str') : '';
	include $core->conf_libs . '/Pages/index.php';
}
else
{
	$include_page = $core->conf_libs . '/Pages/' . $uri[0] . '.php';
	$base_page = $core->conf_base . '/' . $uri[0] . '.php';
	if (file_exists($include_page))
	{
		include $include_page;
	}
	elseif (file_exists($base_page))
	{
		include $base_page;
	}
	else
	{
		include $core->conf_libs . '/Pages/error404.php';
	}
}