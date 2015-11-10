<?php

/**
 * Administration panel - Configuration
 *
 * @package Feliz
 * @version 0.9.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('admin', 'a');
cot_block($usr['isadmin']);

require_once cot_incfile('system', 'configuration');

$adminsubtitle = $L['Configuration'];

$t = new FTemplate(cot_tplfile('admin.config', 'system'));


/* === Hook === */
foreach (cot_getextensions('admin.config.first') as $ext)
{
	include $ext;
}
/* ===== */

$out['breadcrumbs'][] = array(cot_url('admin', 't=config'), $L['Configuration']);

$sql = $db->query("SELECT DISTINCT(config_cat) FROM $db_config
	WHERE config_owner='system' AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "'	ORDER BY config_cat ASC");
$config = array();
while ($row = $sql->fetch())
{
	if ($L['core_' . $row['config_cat']])
	{
		$icofile = $cfg['themes_dir'] . '/admin/'.$cfg['admintheme'].'/img/cfg_' . $row['config_cat'] . '.png';
		$config[] = array(
			'URL' => cot_url('admin', 't=config&m=edit&p=' . $row['config_cat']),
			'ICO' => (file_exists($icofile)) ? $icofile : '',
			'NAME' => $L['core_' . $row['config_cat']],
			'DESC' => $L['core_' . $row['config_cat'] . '_desc'],
		);

	}
}
$t->assign('ADMIN_CONFIG_MAIN', $config);
$sql->closeCursor();

$sql = $db->query("SELECT DISTINCT(config_owner) FROM $db_config
	WHERE config_owner <> 'system' AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "' ORDER BY config_owner ASC");
$config = array();
while ($row = $sql->fetch())
{
	$ext_info = cot_get_extensionparams($row['config_owner']);
	$config[] = array(
		'URL' => cot_url('admin', 't=config&m=edit&e=' . $row['config_owner']),
		'ICO' => $ext_info['icon'],
		'NAME' => $ext_info['name'],
		'DESC' => $ext_info['desc'],
	);
	$t->parse('MAIN.ADMIN_CONFIG_COL.ADMIN_CONFIG_ROW');
}
$t->assign('ADMIN_CONFIG_EXT', $config);
$sql->closeCursor();

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

$adminmain = $t->text();
