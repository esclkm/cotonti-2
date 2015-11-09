<?php

/**
 * Administration panel - Configuration
 *
 * @package Cotonti
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
cot_block($usr['isadmin']);

require_once cot_incfile('system', 'configuration');

$adminsubtitle = $L['Configuration'];

$t = new XTemplate(cot_tplfile('admin.config', 'system'));


/* === Hook === */
foreach (cot_getextensions('admin.config.first') as $ext)
{
	include $ext;
}
/* ===== */

$out['breadcrumbs'][] = array(cot_url('admin', 't=config'), $L['Configuration']);

$sql = $db->query("SELECT DISTINCT(config_cat) FROM $db_config
	WHERE config_owner='system' AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "'	ORDER BY config_cat ASC");

$jj = 0;
while ($row = $sql->fetch())
{
	$jj++;
	if ($L['core_' . $row['config_cat']])
	{
		$icofile = $cfg['system_dir'] . '/admin/img/cfg_' . $row['config_cat'] . '.png';
		$t->assign(array(
			'ADMIN_CONFIG_ROW_URL' => cot_url('admin', 't=config&m=edit&e=system&p=' . $row['config_cat']),
			'ADMIN_CONFIG_ROW_ICO' => (file_exists($icofile)) ? $icofile : '',
			'ADMIN_CONFIG_ROW_NAME' => $L['core_' . $row['config_cat']],
			'ADMIN_CONFIG_ROW_DESC' => $L['core_' . $row['config_cat'] . '_desc'],
			'ADMIN_CONFIG_ROW_NUM' => $jj,
			'ADMIN_CONFIG_ROW_ODDEVEN' => cot_build_oddeven($jj)
		));
		$t->parse('MAIN.ADMIN_CONFIG_COL.ADMIN_CONFIG_ROW');
	}
}
$sql->closeCursor();
$t->assign('ADMIN_CONFIG_COL_CAPTION', $L['Core']);
$t->parse('MAIN.ADMIN_CONFIG_COL');


$sql = $db->query("SELECT DISTINCT(config_owner) FROM $db_config
	WHERE config_owner <> 'system' AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "' ORDER BY config_owner ASC");

$jj = 0;
while ($row = $sql->fetch())
{
	$jj++;
	$ext_info = cot_get_extensionparams($row['config_owner']);
	$t->assign(array(
		'ADMIN_CONFIG_ROW_URL' => cot_url('admin', 't=config&m=edit&e=' . $row['config_owner']),
		'ADMIN_CONFIG_ROW_ICO' => $ext_info['icon'],
		'ADMIN_CONFIG_ROW_NAME' => $ext_info['name'],
		'ADMIN_CONFIG_ROW_DESC' => $ext_info['desc'],
		'ADMIN_CONFIG_ROW_NUM' => $jj,
		'ADMIN_CONFIG_ROW_ODDEVEN' => cot_build_oddeven($jj)
	));
	$t->parse('MAIN.ADMIN_CONFIG_COL.ADMIN_CONFIG_ROW');
}
$sql->closeCursor();
$t->assign('ADMIN_CONFIG_COL_CAPTION', $L['Extensions']);
$t->parse('MAIN.ADMIN_CONFIG_COL');

/* === Hook  === */
foreach (cot_getextensions('admin.config.default.tags') as $ext)
{
	include $ext;
}
/* ===== */

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.config.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
