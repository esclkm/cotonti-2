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

$p = cot_import('p', 'G', 'ALP');
$v = cot_import('v', 'G', 'ALP');

$optionslist = cot_config_list($e, $p, '');
cot_die(!sizeof($optionslist), true);

/* === Hook  === */
foreach (cot_getextensions('admin.config.edit.first') as $ext)
{
	include $ext;
}
/* ===== */

if ($a == 'update' && !empty($_POST))
{
	foreach ($optionslist as $key => $val)
	{
		$data = cot_import($key, 'P', sizeof($cot_import_filters[$key]) ? $key : 'NOC');
		if ($optionslist[$key]['config_value'] != $val)
		{
			if(empty($e))
			{
				$count = $db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
				AND config_cat = ?", array($key, 'system', $p));
			}
			else
			{
				$db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
				AND (config_cat = '' OR config_cat IS NULL OR config_cat = '__default')", array($key, $e));				
			}
			$optionslist[$key]['config_value'] = $data;
		}
	}

	if (!empty($e))
	{
		// Run configure extension part if present
		if (file_exists($cfg['extensions_dir'] . "/" . $e . "/setup/" . $e . ".configure.php"))
		{
			include $cfg['extensions_dir'] . "/" . $e . "/setup/" . $e . ".configure.php";
		}
	}
	/* === Hook  === */
	foreach (cot_getextensions('admin.config.edit.update.done') as $ext)
	{
		include $ext;
	}
	/* ===== */
	$cache && $cache->clear();

	cot_message('Updated');
}
elseif ($a == 'reset' && !empty($v))
{
	cot_config_reset($p, $v, '');

	$optionslist[$v]['config_name'] = $optionslist[$v]['config_defaul'];
	/* === Hook  === */
	foreach (cot_getextensions('admin.config.edit.reset.done') as $ext)
	{
		include $ext;
	}
	/* ===== */
	$cache && $cache->clear();
}


if (empty($e))
{
	$out['breadcrumbs'][] = array(cot_url('admin', 't=config'), $L['Configuration']);
	$out['breadcrumbs'][] = array(cot_url('admin', 't=config&m=edit&p=' . $p), $L['core_' . $p]);
}
else
{
	$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
	$ext_info = cot_get_extensionparams($e);
	$out['breadcrumbs'][] = array(cot_url('admin', "t=extensions&a=details&e=$e"), $ext_info['name']);

	$out['breadcrumbs'][] = array(cot_url('admin', 't=config&m=edit&e=' . $e ), $L['Configuration']);
}

if (!empty($e) && file_exists(cot_langfile($e)))
{
	require cot_langfile($e);
}
if (!empty($e) && file_exists(cot_incfile($e)))
{
	require_once cot_incfile($e);
}

$t = new FTemplate(cot_tplfile('admin.config.edit', 'system'));
/* === Hook  === */
foreach (cot_getextensions('admin.config.edit.main') as $ext)
{
	include $ext;
}
/* ===== */

/* === Hook - Part1 : Set === */
$extp = cot_getextensions('admin.config.edit.loop');
/* ===== */

$configs = array();
foreach ($optionslist as $key => $row)
{
	list($title, $hint) = cot_config_titles($row['config_name'], $row['config_text']);
	
	
	if ($row['config_subcat'] == '__default' && $prev_subcat == '' && $row['config_type'] != COT_CONFIG_TYPE_SEPARATOR)
	{
		$configs[] = array(
			'TITLE' => $L['cfg_struct_defaults'],
			'SEPARATOR' => true
		);
	}
	if ($row['config_type'] == COT_CONFIG_TYPE_SEPARATOR)
	{
		$configs[] = array(
			'TITLE' => $title,
			'SEPARATOR' => true
		);
	}
	else
	{
		$configs[] = array(
			'CONFIG' => cot_config_input($row['config_name'], $row['config_type'], $row['config_value'], $row['config_variants']),
			'TITLE' => $title,
			'RESET' => cot_url('admin', "t=config&m=edit&e=$e&p=$p&a=reset&v=" . $row['config_name']),
			'MORE' => $hint
		);
		/* === Hook - Part2 : Include === */
		foreach ($extp as $ext)
		{
			include $ext;
		}
		/* ===== */
	}

	$prev_subcat = $row['config_subcat'];
}

$t->assign(array(
	'ADMIN_CONFIG_ROWS' => $configs,
	'ADMIN_CONFIG_FORM_URL' => cot_url('admin', 't=config&m=edit&e=' . $e . '&p=' . $p . '&a=update')
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.config.edit.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
