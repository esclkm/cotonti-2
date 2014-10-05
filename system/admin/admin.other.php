<?php
/**
 * Administration panel - Other Admin parts listing
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

$t = new XTemplate(cot_tplfile('admin.other', 'core'));


$p = cot_import('p', 'G', 'ALP');

/* === Hook === */
foreach (cot_getextensions('admin.other.first') as $pl)
{
	include $pl;
}
/* ===== */

$adminpath[] = array(cot_url('admin', 'm=other'), $L['Other']);
$adminsubtitle = $L['Other'];
list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
cot_block($usr['auth_read']);

$target = array();

function cot_admin_other_cmp($pl_a, $pl_b)
{
	if($pl_a['ext_code'] == $pl_b['ext_code'])
	{
		return 0;
	}
	return ($pl_a['ext_code'] < $pl_b['ext_code']) ? -1 : 1;
}

foreach (array('module') as $type)
{
	$target = $cot_extensions['admin'];
	$title = $L['Extensions'];

	if (is_array($target))
	{
		usort($target, 'cot_admin_other_cmp');
		foreach ($target as $pl)
		{
			$ext_info = cot_get_extensionparams($pl['ext_code']);
			$t->assign(array(
				'ADMIN_OTHER_EXT_URL' => cot_url('admin', 'm=' . $pl['ext_code']),
				'ADMIN_OTHER_EXT_ICO' => $ext_info['icon'],
				'ADMIN_OTHER_EXT_NAME' => $ext_info['name'],
				'ADMIN_OTHER_EXT_DESC' => $ext_info['desc']
			));
			$t->parse('MAIN.SECTION.ROW');
		}
	}
	else
	{
		$t->parse('MAIN.SECTION.EMPTY');
	}
	$t->assign('ADMIN_OTHER_SECTION', $title);
	$t->parse('MAIN.SECTION');
}

$t->assign(array(
	'ADMIN_OTHER_URL_CACHE' => cot_url('admin', 'm=cache'),
	'ADMIN_OTHER_URL_DISKCACHE' => cot_url('admin', 'm=cache&s=disk'),
	'ADMIN_OTHER_URL_EXFLDS' => cot_url('admin', 'm=extrafields'),
	'ADMIN_OTHER_URL_STRUCTURE' => cot_url('admin', 'm=structure'),
	'ADMIN_OTHER_URL_BBCODE' => cot_url('admin', 'm=bbcode'),
	'ADMIN_OTHER_URL_LOG' => cot_url('admin', 'm=log'),
	'ADMIN_OTHER_URL_INFOS' => cot_url('admin', 'm=infos')
));

/* === Hook === */
foreach (cot_getextensions('admin.other.tags') as $pl)
{
	include $pl;
}
/* ===== */
$t->parse('MAIN');
$adminmain = $t->text('MAIN');

