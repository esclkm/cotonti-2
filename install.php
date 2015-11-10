<?php
/**
 * Install script
 *
 * @package Feliz
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

// Environment setup
define('COT_CODE', TRUE);
define('COT_INSTALL', TRUE);
//define('COT_ADMIN', TRUE);
$env['location'] = 'install';
$env['ext'] = 'install';

if (file_exists('./datas/config.php'))
{
	require_once './datas/config.php';
}
else
{
	require_once './datas/config-sample.php';
}

if (empty($cfg['extensions_dir']))
{
	$cfg['extensions_dir'] = './extensions';
}
if (empty($cfg['lang_dir']))
{
	$cfg['lang_dir'] = './lang';
}

// Force config options
$cfg['display_errors'] = true;
$cfg['debug_mode'] = true;
$cfg['customfuncs'] = false;
$cfg['cache'] = false;
$cfg['xtpl_cache'] = false;

require_once $cfg['system_dir'].'/functions.php';
require_once $cfg['system_dir'] . '/FTemplate.php';
FTemplate::init(array(
	'cache_dir'    => $cfg['cache_dir'].'/fenom',
	'auto_reload' => true,
	'force_compile' => true
));
require_once 'system/debug.php';

if (isset($cfg['new_install']) && $cfg['new_install'])
{
	require_once $cfg['system_dir'].'/database.php';

	// A Few basics from common.php
	if (version_compare(PHP_VERSION, '6.0.0', '<='))
	{
		if (get_magic_quotes_gpc())
		{
			function cot_disable_mqgpc(&$value, $key)
			{
				$value = stripslashes($value);
			}
			$gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
			array_walk_recursive($gpc, 'cot_disable_mqgpc');
		}
	}
	define('MQGPC', FALSE);
	error_reporting(E_ALL ^ E_NOTICE);

	session_start();

	// Getting the server-relative path
	$url = parse_url($cfg['mainurl']);
	$sys['secure'] = $url['scheme'] == 'https' ? true : false;
	$sys['scheme'] = $url['scheme'];
	$sys['site_uri'] = $url['path'];
	$sys['host'] = $url['host'];
	$sys['domain'] = preg_replace('#^www\.#', '', $url['host']);
	if ($sys['site_uri'][mb_strlen($sys['site_uri']) - 1] != '/') $sys['site_uri'] .= '/';
	$sys['port'] = empty($url['port']) ? '' : ':' . $url['port'];
	$sys['abs_url'] = $url['scheme'] . '://' . $sys['host'] . $sys['port'] . $sys['site_uri'];

	// Installer language selection support
	if (empty($_SESSION['cot_inst_lang']))
	{
		$lang = cot_import('lang', 'P', 'ALP');
		if (empty($lang))
		{
			$lang = cot_lang_determine();
		}
	}

	else
	{
		$lang = $_SESSION['cot_inst_lang'];
	}

	require_once cot_langfile('main', 'system');
	require_once $cfg['system_dir'] . '/resources.php';
}
else
{
	$branch = 'siena';

	require_once $cfg['system_dir'].'/database.php';

	$dbc_port = empty($cfg['mysqlport']) ? '' : ';port='.$cfg['mysqlport'];
	$db = new CotDB('mysql:host='.$cfg['mysqlhost'].$dbc_port.';dbname='.$cfg['mysqldb'], $cfg['mysqluser'], $cfg['mysqlpassword']);

	cot::init();

	$sql_install = @$db->query("SHOW TABLES LIKE '$db_updates'");

	if ($sql_install->rowCount() != 1)
	{
		define('COT_UPGRADE', true);
		$cfg['defaulttheme'] = 'nemesis';
		$cfg['defaultscheme'] = 'default';
	}
	require_once $cfg['system_dir'].'/common.php';
}

require_once cot_incfile('system', 'forms');
require_once cot_incfile('system', 'extensions');
require_once cot_langfile('install');
require_once cot_langfile('users', 'system');
require_once cot_langfile('admin', 'system');

include cot_incfile('install');
require_once cot_incfile('install', 'resources');

// Various Generic Vars needed to operate as Normal
$theme = $cfg['defaulttheme'];
$scheme = $cfg['defaultscheme'];
$out['meta_lastmod'] = gmdate('D, d M Y H:i:s');
$file['config'] = './datas/config.php';
$file['config_sample'] = './datas/config-sample.php';
$file['sql'] = './setup/install.sql';

if (!$cfg['new_install'])
{
	include cot_incfile('install', 'update');
}
else
{
	include cot_incfile('install', 'install');
}
