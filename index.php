<?php

/**
 * Index loader
 *
 * @package Cotonti
 * @version 0.9.17
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
if (php_sapi_name() == 'cli-server')
{
	// Embedded PHP webserver routing
	$tmp = explode('?', $_SERVER['REQUEST_URI']);
	$REQUEST_FILENAME = mb_substr($tmp[0], 1);
	unset($tmp);
	if (file_exists($REQUEST_FILENAME) && !preg_match('#\.php$#', $REQUEST_FILENAME))
	{
		// Transfer static file if exists
		return false;
	}
	// Language selector
	$langs = array_map(
		create_function('$dir', 'return str_replace("lang/", "", $dir);'), glob('lang/??', GLOB_ONLYDIR)
	);
	if (preg_match('#^('.join('|', $langs).')/(.*)$#', $REQUEST_FILENAME, $mt))
	{
		$REQUEST_FILENAME = $mt[2];
		$_GET['l'] = $mt[1];
	}
	// Sitemap shortcut
	if ($REQUEST_FILENAME === 'sitemap.xml')
	{
		$_GET['r'] = 'sitemap';
	}
	// Admin area and message are special scripts
	if (preg_match('#^admin/([a-z0-9]+)#', $REQUEST_FILENAME, $mt))
	{
		$_GET['m'] = $mt[1];
		include 'admin.php';
		exit;
	}
	if (preg_match('#^(admin|login|message)(/|$)#', $REQUEST_FILENAME, $mt))
	{
		include $mt[1].'.php';
		exit;
	}
	// PHP files have priority
	if (preg_match('#\.php$#', $REQUEST_FILENAME))
	{
		include $REQUEST_FILENAME;
		exit;
	}
	// All the rest goes through standard rewrite gateway
	$_GET['rwr'] = $REQUEST_FILENAME;
	unset($REQUEST_FILENAME, $langs, $mt);
}

// Redirect to install if config is missing
if (!file_exists('./datas/config.php'))
{
	header('Location: install.php');
	exit;
}

// Let the include files know that we are Cotonti
define('COT_CODE', true);

// Load vital core configuration from file
require_once './datas/config.php';

// If it is a new install, redirect
if (isset($cfg['new_install']) && $cfg['new_install'])
{
	header('Location: install.php');
	exit;
}

// Load the Core API, the template engine
require_once $cfg['system_dir'].'/functions.php';
require_once $cfg['system_dir'].'/cotemplate.php';
require_once $cfg['system_dir'].'/common.php';

// Support for ajax and popup hooked extensions
if (empty($_GET['e']) && !empty($_GET['r']))
{
	$_GET['e'] = $_GET['r'];
}

// Detect selected extension
$env['ext'] = 'index';
if (!empty($_GET['e']))
{
	$env['ext'] = $_GET['e'];
}
elseif (!empty($_GET['r']))
{
	$env['ext'] = $_GET['r'];
}

$found = array();
if (preg_match('`^\w+$`', $env['ext']) && isset($cot_extensions[$env['ext']]))
{
	$exthook = (!empty($_GET['r'])) ? 'ajax' : 'standalone';
	if (is_array($cot_hooks[$exthook]))
	{
		foreach ($cot_hooks[$exthook] as $hook)
		{
			if ($hook['ext_code'] == $env['ext'] && file_exists($cfg['extensions_dir'].'/'.$hook['ext_file']))
			{
				$found[] = $cfg['extensions_dir'].'/'.$hook['ext_file'];
			}
		}
	}
}

if (count($found))
{
	$req_files = array();
	$req_files[] = cot_incfile($env['ext'], 'resources');
	$req_files[] = cot_incfile($env['ext'], 'functions');

	foreach ($req_files as $req_file)
	{
		if (file_exists($req_file))
		{
			require_once $req_file;
		}
	}
	foreach ($found as $file)
	{
		require_once $file;
	}
	define('COT_MODULE', true);
	$env['ext'] = $_GET['e'];
}
else
{
	// Error page
	cot_die_message(404);
	exit;
}