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

$t = new XTemplate(cot_tplfile('admin.config.edit', 'system'));

$p = cot_import('p', 'G', 'ALP');
$v = cot_import('v', 'G', 'ALP');
$e = empty($e) ? 'system' : $e;

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
			if($e == 'system')
			{
				$db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
				AND config_cat = ?", array($key, $o, $p));
			}
			else
			{
				$db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
				AND (config_cat = '' OR config_cat IS NULL OR config_cat = '__default')", array($key, $o));				
			}
			$optionslist[$key]['config_value'] = $data;
		}
	}

	if ($o == 'extension')
	{
		// Run configure extension part if present
		if (file_exists($cfg['extensions_dir'] . "/" . $p . "/setup/" . $p . ".configure.php"))
		{
			include $cfg['extensions_dir'] . "/" . $p . "/setup/" . $p . ".configure.php";
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


if ($e == 'system')
{
	$out['breadcrumbs'][] = array(cot_url('admin', 't=config'), $L['Configuration']);
	$out['breadcrumbs'][] = array(cot_url('admin', 't=config&m=edit&e=' . $e . '&p=' . $p), $L['core_' . $p]);
}
else
{
	$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
	$ext_info = cot_get_extensionparams($p);
	$out['breadcrumbs'][] = array(cot_url('admin', "t=extensions&a=details&mod=$p"), $ext_info['name']);

	$out['breadcrumbs'][] = array(cot_url('admin', 't=config&m=edit&e=' . $e . '&p=' . $p), $L['Configuration']);
}

if ($e != 'system' && file_exists(cot_langfile($e)))
{
	require cot_langfile($e);
}
if ($e != 'system' && file_exists(cot_incfile($e)))
{
	require_once cot_incfile($e);
}

/* === Hook  === */
foreach (cot_getextensions('admin.config.edit.main') as $ext)
{
	include $ext;
}
/* ===== */

/* === Hook - Part1 : Set === */
$extp = cot_getextensions('admin.config.edit.loop');
/* ===== */

foreach ($optionslist as $key => $row)
{
	list($title, $hint) = cot_config_titles($row['config_name'], $row['config_text']);

	if ($row['config_subcat'] == '__default' && $prev_subcat == '' && $row['config_type'] != COT_CONFIG_TYPE_SEPARATOR)
	{
		$t->assign('ADMIN_CONFIG_FIELDSET_TITLE', $L['cfg_struct_defaults']);
		$t->parse('MAIN.ADMIN_CONFIG_ROW.ADMIN_CONFIG_FIELDSET_BEGIN');
	}
	if ($row['config_type'] == COT_CONFIG_TYPE_SEPARATOR)
	{
		$t->assign('ADMIN_CONFIG_FIELDSET_TITLE', $title);
		$t->parse('MAIN.ADMIN_CONFIG_ROW.ADMIN_CONFIG_FIELDSET_BEGIN');
	}
	else
	{
		$t->assign(array(
			'ADMIN_CONFIG_ROW_CONFIG' => cot_config_input($row['config_name'], $row['config_type'], $row['config_value'], $row['config_variants']),
			'ADMIN_CONFIG_ROW_CONFIG_TITLE' => $title,
			'ADMIN_CONFIG_ROW_CONFIG_MORE_URL' =>
			cot_url('admin', "t=config&m=edit&e=$e&p=$p&a=reset&v=" . $row['config_name']),
			'ADMIN_CONFIG_ROW_CONFIG_MORE' => $hint
		));
		/* === Hook - Part2 : Include === */
		foreach ($extp as $ext)
		{
			include $ext;
		}
		/* ===== */
		$t->parse('MAIN.ADMIN_CONFIG_ROW.ADMIN_CONFIG_ROW_OPTION');
	}
	$t->parse('MAIN.ADMIN_CONFIG_ROW');
	$prev_subcat = $row['config_subcat'];
}

$t->assign(array(
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
