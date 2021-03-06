<?php
/**
 * Administration panel loader
 *
 * @package Feliz
 * @version 0.9.15
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

define('COT_CODE', TRUE);
define('COT_ADMIN', TRUE);
define('COT_CORE', TRUE);

require_once './datas/config.php';
require_once $cfg['system_dir'] . '/functions.php';

$env['location'] = 'administration';
$env['ext'] = 'admin';

require_once $cfg['system_dir'] . '/cotemplate.php';
require_once $cfg['system_dir'] . '/common.php';

require_once cot_incfile('admin', 'functions');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'any');

cot_block($usr['auth_read']);

if (!empty($e) && !file_exists($cfg['extensions_dir'] . '/' . $e . '/' . $e . '.setup.php'))
{
	unset($e); 
}

$usr['admin_config'] = cot_auth('admin', 'a', 'A');
$usr['admin_structure'] = cot_auth('structure', 'a', 'A');
$usr['admin_users'] = cot_auth('users', 'a', 'A') || $usr['maingrp'] == COT_GROUP_SUPERADMINS;

$out['breadcrumbs'] = array(array(cot_url('admin'), $L['Adminpanel']));


if(!empty($e))
{
	$req_files = [
		cot_incfile($e, 'resources'),
		cot_incfile($e, 'functions'),
		cot_langfile($e),
	];
	foreach ($req_files as $req_file)
	{
		if (file_exists($req_file))
		{
			require_once $req_file;
		}
	}
}

if(empty($t) && !empty($e)) // TODO: исправить на учет хуков
{
	$adminsubtitle = $cot_extensions[$e]['title'];
	$inc_file = $cfg['extensions_dir'] . "/$e/$e.admin.php";
	foreach ($cot_hooks['admin'] as $hook)
	{
		if ($hook['ext_code'] == $e && file_exists($cfg['extensions_dir'].'/'.$hook['ext_file']))
		{
			$found[] = $cfg['extensions_dir'].'/'.$hook['ext_file'];
		}
	}
}
else
{
	$inc_file = cot_incfile('admin', 'home');	
	if(file_exists(cot_incfile('admin', $t)))
	{
		$inc_file = cot_incfile('admin', $t);
	}
	if(!empty($m) && file_exists(cot_incfile('admin', $t.'.'.$m)))
	{
		$inc_file = cot_incfile('admin', $t.'.'.$m);
	}
	$found[] = $inc_file;
}

if (!count($found))
{
	cot_die();
}
foreach ($found as $file)
{
	require_once $file;
}

$title_params = array(
	'ADMIN' => $L['Administration'],
	'SUBTITLE' => $adminsubtitle
);
$out['head'] .= $R['code_noindex'];
$out['subtitle'] = empty($adminsubtitle) ? cot_title('{ADMIN}', $title_params) : cot_title('{SUBTITLE} - {ADMIN}', $title_params);

require_once $cfg['system_dir'].'/header.php';

echo $adminmain;

require_once $cfg['system_dir'].'/footer.php';
