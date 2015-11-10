<?php
/**
 * Administration panel - PHP Infos
 *
 * @package Feliz
 * @version 0.1.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
cot_block($usr['auth_read']);

$t = new XTemplate(cot_tplfile('admin.infos', 'system'));

$out['breadcrumbs'][] = array(cot_url('admin', 't=other'), $L['Other']);
$out['breadcrumbs'][] = array(cot_url('admin', 't=infos'), $L['adm_infos']);

$adminsubtitle = $L['adm_infos'];

/* === Hook === */
foreach (cot_getextensions('admin.infos.first') as $ext)
{
	include $ext;
}
/* ===== */

@error_reporting(0);

$t->assign(array(
	'ADMIN_INFOS_PHPVER' => (function_exists('phpversion')) ? phpversion() : $L['adm_help_config'],
	'ADMIN_INFOS_ZENDVER' => (function_exists('zend_version')) ? zend_version() : $L['adm_help_config'],
	'ADMIN_INFOS_INTERFACE' => (function_exists('php_sapi_name')) ? php_sapi_name() : $L['adm_help_config'],
	'ADMIN_INFOS_CACHEDRIVERS' => (is_array($cot_cache_drivers)) ? implode(', ', $cot_cache_drivers) : '',
	'ADMIN_INFOS_OS' => (function_exists('php_uname')) ? php_uname() : $L['adm_help_config'],
	'ADMIN_INFOS_DATE' => cot_date('datetime_medium', $sys['now'], false),
	'ADMIN_INFOS_GMDATE' => gmdate('Y-m-d H:i'),
	'ADMIN_INFOS_GMTTIME' => $usr['gmttime'],
	'ADMIN_INFOS_USRTIME' => $usr['localtime'],
	'ADMIN_INFOS_TIMETEXT' => $usr['timetext'],
	'ADMIN_INFOS_BREADCRUMBS' => cot_breadcrumbs($out['breadcrumbs'], false),
));

/* === Hook === */
foreach (cot_getextensions('admin.infos.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');

@error_reporting(7);
