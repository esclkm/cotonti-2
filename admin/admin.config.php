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

switch ($n)
{
	case 'edit':
		$o = cot_import('o', 'G', 'ALP');
		$p = cot_import('p', 'G', 'ALP');
		$v = cot_import('v', 'G', 'ALP');
		$o = empty($o) ? 'system' : $o;
		$p = empty($p) ? 'global' : $p;
		$o == 'module' ? 'extemsion' : 'core' ? 'system' : $o;

		$optionslist = cot_config_list($o, $p, '');
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
					$db->update($db_config, array('config_value' => $data), "config_name = ? AND config_owner = ?
					AND config_cat = ?  AND (config_subcat = '' OR config_subcat IS NULL OR config_subcat = '__default')", array($key, $o, $p));
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


		if ($o == 'core')
		{
			$adminpath[] = array(cot_url('admin', 'm=config'), $L['Configuration']);
			$adminpath[] = array(cot_url('admin', 'm=config&n=edit&o=' . $o . '&p=' . $p), $L['core_' . $p]);
		}
		else
		{
			$adminpath[] = array(cot_url('admin', 'm=extensions'), $L['Extensions']);
			$ext_info = cot_get_extensionparams($p);
			$adminpath[] = array(cot_url('admin', "m=extensions&a=details&mod=$p"), $ext_info['name']);

			$adminpath[] = array(cot_url('admin', 'm=config&n=edit&o=' . $o . '&p=' . $p), $L['Configuration']);
		}

		if ($o != 'core' && file_exists(cot_langfile($p)))
		{
			require cot_langfile($p);
		}
		if ($o != 'core' && file_exists(cot_incfile($p)))
		{
			require_once cot_incfile($p);
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
				$t->parse('MAIN.EDIT.ADMIN_CONFIG_ROW.ADMIN_CONFIG_FIELDSET_BEGIN');
			}
			if ($row['config_type'] == COT_CONFIG_TYPE_SEPARATOR)
			{
				$t->assign('ADMIN_CONFIG_FIELDSET_TITLE', $title);
				$t->parse('MAIN.EDIT.ADMIN_CONFIG_ROW.ADMIN_CONFIG_FIELDSET_BEGIN');
			}
			else
			{
				$t->assign(array(
					'ADMIN_CONFIG_ROW_CONFIG' => cot_config_input($row['config_name'], $row['config_type'], $row['config_value'], $row['config_variants']),
					'ADMIN_CONFIG_ROW_CONFIG_TITLE' => $title,
					'ADMIN_CONFIG_ROW_CONFIG_MORE_URL' =>
					cot_url('admin', "m=config&n=edit&o=$o&p=$p&a=reset&v=" . $row['config_name']),
					'ADMIN_CONFIG_ROW_CONFIG_MORE' => $hint
				));
				/* === Hook - Part2 : Include === */
				foreach ($extp as $ext)
				{
					include $ext;
				}
				/* ===== */
				$t->parse('MAIN.EDIT.ADMIN_CONFIG_ROW.ADMIN_CONFIG_ROW_OPTION');
			}
			$t->parse('MAIN.EDIT.ADMIN_CONFIG_ROW');
			$prev_subcat = $row['config_subcat'];
		}

		$t->assign(array(
			'ADMIN_CONFIG_FORM_URL' => cot_url('admin', 'm=config&n=edit&o=' . $o . '&p=' . $p . '&a=update')
		));
		/* === Hook  === */
		foreach (cot_getextensions('admin.config.edit.tags') as $ext)
		{
			include $ext;
		}
		/* ===== */
		$t->parse('MAIN.EDIT');
		break;

	default:
		$adminpath[] = array(cot_url('admin', 'm=config'), $L['Configuration']);
		$sql = $db->query("
			SELECT DISTINCT(config_cat) FROM $db_config
			WHERE config_owner='system'
			AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "'
			ORDER BY config_cat ASC
		");
		$jj = 0;
		while ($row = $sql->fetch())
		{
			$jj++;
			if ($L['core_' . $row['config_cat']])
			{
				$icofile = $cfg['system_dir'] . '/admin/img/cfg_' . $row['config_cat'] . '.png';
				$t->assign(array(
					'ADMIN_CONFIG_ROW_URL' => cot_url('admin', 'm=config&n=edit&o=core&p=' . $row['config_cat']),
					'ADMIN_CONFIG_ROW_ICO' => (file_exists($icofile)) ? $icofile : '',
					'ADMIN_CONFIG_ROW_NAME' => $L['core_' . $row['config_cat']],
					'ADMIN_CONFIG_ROW_DESC' => $L['core_' . $row['config_cat'] . '_desc'],
					'ADMIN_CONFIG_ROW_NUM' => $jj,
					'ADMIN_CONFIG_ROW_ODDEVEN' => cot_build_oddeven($jj)
				));
				$t->parse('MAIN.DEFAULT.ADMIN_CONFIG_COL.ADMIN_CONFIG_ROW');
			}
		}
		$sql->closeCursor();
		$t->assign('ADMIN_CONFIG_COL_CAPTION', $L['Core']);
		$t->parse('MAIN.DEFAULT.ADMIN_CONFIG_COL');
		$sql = $db->query("
			SELECT DISTINCT(config_cat) FROM $db_config
			WHERE config_owner = 'extension'
			AND config_type != '" . COT_CONFIG_TYPE_HIDDEN . "'
			ORDER BY config_cat ASC
		");
		$jj = 0;
		while ($row = $sql->fetch())
		{
			$jj++;
			$ext_info = cot_get_extensionparams($row['config_cat']);
			$t->assign(array(
				'ADMIN_CONFIG_ROW_URL' => cot_url('admin', 'm=config&n=edit&p=' . $row['config_cat']),
				'ADMIN_CONFIG_ROW_ICO' => $ext_info['icon'],
				'ADMIN_CONFIG_ROW_NAME' => $ext_info['name'],
				'ADMIN_CONFIG_ROW_DESC' => $ext_info['desc'],
				'ADMIN_CONFIG_ROW_NUM' => $jj,
				'ADMIN_CONFIG_ROW_ODDEVEN' => cot_build_oddeven($jj)
			));
			$t->parse('MAIN.DEFAULT.ADMIN_CONFIG_COL.ADMIN_CONFIG_ROW');
		}
		$sql->closeCursor();
		$t->assign('ADMIN_CONFIG_COL_CAPTION', $L['Extensions']);
		$t->parse('MAIN.DEFAULT.ADMIN_CONFIG_COL');

		/* === Hook  === */
		foreach (cot_getextensions('admin.config.default.tags') as $ext)
		{
			include $ext;
		}
		/* ===== */
		$t->parse('MAIN.DEFAULT');
		break;
}

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.config.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
