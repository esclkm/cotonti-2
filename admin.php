<?php
/**
 * Administration panel loader
 *
 * @package Cotonti
 * @version 0.9.15
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
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
$standard_admin = array('cache', 'config', 'extrafields', 'home', 'infos',
	'log', 'extensions', 'rights', 'rightsbyitem', 'structure', 'urls', 'users');

$inc_file = (empty($t)) ? 'home' : $t;
$inc_file = (empty($m)) ? $inc_file : $inc_file.'.'.$m;

if(empty($t) && !empty($e)) // TODO: исправить на учет хуков
{
	$env['ext'] = $e;
	$adminsubtitle = $cot_extensions[$e]['title'];
	$inc_file = $cfg['extensions_dir'] . "/$e/$e.admin.php";
}
elseif (in_array($inc_file, $standard_admin) && file_exists(cot_incfile('admin', $inc_file)))
{
	$inc_file = cot_incfile('admin', $inc_file);
}

if (!file_exists($inc_file))
{
	cot_die();
}

$usr['admin_config'] = cot_auth('admin', 'a', 'A');
$usr['admin_structure'] = cot_auth('structure', 'a', 'A');
$usr['admin_users'] = cot_auth('users', 'a', 'A') || $usr['maingrp'] == COT_GROUP_SUPERADMINS;

$out['breadcrumbs'] = array(array(cot_url('admin'), $L['Adminpanel']));

require $inc_file;


$title_params = array(
	'ADMIN' => $L['Administration'],
	'SUBTITLE' => $adminsubtitle
);
$out['head'] .= $R['code_noindex'];
$out['subtitle'] = empty($adminsubtitle) ? cot_title('{ADMIN}', $title_params) : cot_title('{SUBTITLE} - {ADMIN}', $title_params);

require_once $cfg['system_dir'].'/header.php';

echo $adminmain;

require_once $cfg['system_dir'].'/footer.php';
