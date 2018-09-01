<?php
/**
 * An example app routing
 *
 * This is an example of how I work on my application, it is a work in progress but
 * it works. I will work to get it running with Routing soon.
 *
 * Obsidian Moon Engine by Dark Prospect Games
 * An Open Source, Lightweight and 100% Modular Framework in PHP
 *
 * PHP version 7
 *
 * @category  ObsidianMoonEngine
 * @package   DarkProspectGames\ObsidianMoonEngine
 * @author    Alfonso E Martinez, III <opensaurusrex@gmail.com>
 * @copyright 2011-2018 Dark Prospect Games, LLC
 * @license   MIT https://darkprospect.net/MIT-License.txt
 * @link      https://github.com/dark-prospect-games/obsidian-moon-engine/
 */
require dirname(__DIR__) . '/common.php';

$filter = ['/\?.*$/i'];
if ($core->config('subdir')) {
    $filter[] = "/{$core->config('subdir')}/i";
}

// TODO: Finish the Routing module so that we can pull up pages without this.
$uri_raw = str_replace('.php', '', $_SERVER['REQUEST_URI']);
$uri = explode('/', trim(preg_replace($filter, '', $uri_raw), '/'));
if (empty($uri[0])) {
    $str = $core->input->get('str', 'isset') ? $core->input->get('str') : '';
    include $core->config('src') . '/Pages/index.php';
} else {
    $include_page = $core->config('src') . '/Pages/' . $uri[0] . '.php';
    $public_page = $core->config('public') . '/' . $uri[0] . '.php';
    if (file_exists($include_page)) {
        include $include_page;
    } elseif (file_exists($public_page)) {
        include $public_page;
    } else {
        include $core->config('src') . '/Pages/error404.php';
    }
}
