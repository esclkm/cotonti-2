<?php

/**
 * Extension administration
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

require_once cot_incfile('system', 'auth');

$t = new XTemplate(cot_tplfile('admin.extensions', 'system'));

$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
$adminsubtitle = $L['Extensions'];

$part = cot_import('part', 'G', 'TXT');
$sort = cot_import('sort', 'G', 'ALP');

if (empty($e))
{
	if (!empty($m) && $m != 'hooks')
	{
		cot_die();
	}
}

$status[0] = $R['admin_code_paused'];
$status[1] = $R['admin_code_running'];
$status[2] = $R['admin_code_partrunning'];
$status[3] = $R['admin_code_notinstalled'];
$status[4] = $R['admin_code_missing'];
$found_txt[0] = $R['admin_code_missing'];
$found_txt[1] = $R['admin_code_present'];
unset($disp_errors);

/* === Hook === */
foreach (cot_getextensions('admin.extensions.first') as $ext)
{
	include $ext;
}
/* ===== */

/* =============== */
// Params to show only installed extensions
$only_installed = cot_import('inst', 'G', 'BOL');
if ($cfg['default_show_installed'])
{
	if (is_null($only_installed))
	{
		$only_installed = true;
	}
	$only_installed_urlp = $only_installed ? '' : '&inst=0';
	$only_installed_toggle = $only_installed ? '&inst=0' : '';
}
else
{
	$only_installed_urlp = $only_installed ? '&inst=1' : '';
	$only_installed_toggle = $only_installed ? '' : '&inst=1';
}
$sort_urlp = $sort == 'cat' ? '&sort=cat' : '';

// Filter/sort tags
$t->assign(array(
	'ADMIN_EXTENSIONS_HOOKS_URL' => cot_url('admin', 't=extensions&m=hooks'),
	'ADMIN_EXTENSIONS_SORT_ALP_URL' => cot_url('admin', 't=extensions'.$only_installed_urlp),
	'ADMIN_EXTENSIONS_SORT_ALP_SEL' => $sort != 'cat',
	'ADMIN_EXTENSIONS_SORT_CAT_URL' => cot_url('admin', 't=extensions&sort=cat'.$only_installed_urlp),
	'ADMIN_EXTENSIONS_SORT_CAT_SEL' => $sort == 'cat',
	'ADMIN_EXTENSIONS_ALL_EXTENSIONS_URL' => cot_url('admin', 't=extensions'.$sort_urlp),
	'ADMIN_EXTENSIONS_ONLY_INSTALLED_URL' => cot_url('admin', 't=extensions'.$sort_urlp.$only_installed_toggle),
	'ADMIN_EXTENSIONS_ONLY_INSTALLED_SEL' => $only_installed
));

// Prefetch common data to save SQL queries
$totalconfigs = array();
foreach ($db->query("SELECT COUNT(*) AS cnt, config_owner, config_cat
		FROM $db_config WHERE config_type != ".COT_CONFIG_TYPE_HIDDEN."
		GROUP BY config_owner, config_cat")->fetchAll() as $row)
{
	$totalconfigs[$row['config_owner']][$row['config_cat']] = (int)$row['cnt'];
}

$totalactives = array();
$totalinstalleds = array();
foreach ($db->query("SELECT SUM(ext_active) AS sum, COUNT(*) AS cnt, ext_code FROM $db_extension_hooks GROUP BY ext_code")->fetchAll() as $row)
{
	$totalactives[$row['ext_code']] = (int)$row['sum'];
	$totalinstalleds[$row['ext_code']] = (int)$row['cnt'];
}

$installed_vers = array();
foreach ($db->query("SELECT ct_version, ct_code FROM $db_core")->fetchAll() as $row)
{
	$installed_vers[$row['ct_code']] = $row['ct_version'];
}

$sql = $db->query("SELECT DISTINCT(config_cat), COUNT(*) FROM $db_config
	WHERE config_owner='extension' GROUP BY config_cat");
while ($row = $sql->fetch(PDO::FETCH_NUM))
{
	$cfgentries[$row['config_cat']] = $row[0];
}
$sql->closeCursor();

$extensions = cot_extension_list_info($cfg['extensions_dir']);

if ($only_installed)
{
	// Filter only installed exts
	$tmp = array();
	$installed_exts = $db->query("SELECT ct_code FROM $db_core WHERE 1")->fetchAll(PDO::FETCH_COLUMN);
	foreach ($extensions as $key => $val)
	{
		if (in_array($key, $installed_exts))
		{
			$tmp[$key] = $val;
		}
	}
	$extensions = $tmp;
}

// Find missing extensions
$extlist = count($extensions) > 0 ? "ct_code NOT IN('".implode("','", array_keys($extensions))."')" : '1';
$sql = $db->query("SELECT * FROM $db_core WHERE $extlist");
foreach ($sql->fetchAll() as $row)
{
	if (in_array($row['ct_code'], array('admin', 'message', 'users')))
	{
		continue;
	}
	$extensions[$row['ct_code']] = array(
		'Code' => $row['ct_code'],
		'Name' => $row['ct_title'],
		'Version' => $row['ct_version'],
		'Category' => 'misc-ext',
		'NotFound' => true
	);
}

if ($sort == 'cat')
{
	uasort($extensions, 'cot_extension_catcmp');
}
else
{
	uasort($extensions, 'cot_extension_namecmp');
}

$cnt_extp = count($extensions);
$cnt_parts = 0;

$standalone = array();
$sql3 = $db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='standalone' OR ext_hook='module'");
while ($row3 = $sql3->fetch())
{
	$standalone[$row3['ext_code']] = TRUE;
}
$sql3->closeCursor();

$tools = array();
$sql3 = $db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='admin'");
while ($row3 = $sql3->fetch())
{
	$tools[$row3['ext_code']] = TRUE;
}
$sql3->closeCursor();

$struct = array();
$sql3 = $db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='admin.structure.first'");
while ($row3 = $sql3->fetch())
{
	$struct[$row3['ext_code']] = TRUE;
}

$sql3->closeCursor();

$prev_cat = '';
/* === Hook - Part1 : Set === */
$extp = cot_getextensions("admin.extensions.extensions.list.loop");
/* ===== */
foreach ($extensions as $e => $info)
{
	if ($sort == 'cat' && $prev_cat != $info['Category'])
	{
		// Render category heading
		$t->assign('ADMIN_EXTENSIONS_CAT_TITLE', $L['ext_cat_'.$info['Category']]);
		$t->parse('MAIN.DEFAULT.SECTION.ROW.ROW_CAT');
		// Assign a new one
		$prev_cat = $info['Category'];
	}

	$exists = !isset($info['NotFound']);

	if (!empty($info['Error']))
	{
		$t->assign(array(
			'ADMIN_EXTENSIONS_X_ERR' => $e,
			'ADMIN_EXTENSIONS_ERROR_MSG' => $info['Error']
		));
		$t->parse('MAIN.ROW.ROW_ERROR_EXT');
		$t->parse('MAIN.ROW');
	}
	else
	{
		$totalactive = $totalactives[$e];
		$totalinstalled = $totalinstalleds[$e];

		$cnt_parts += $totalinstalled;

		if (!isset($installed_vers[$e]))
		{
			$part_status = 3;
			$info['Partscount'] = '?';
		}
		else
		{
			$info['Partscount'] = $totalinstalled;
			if (!$exists)
			{
				$part_status = 4;
			}
			elseif ($totalinstalled > $totalactive && $totalactive > 0)
			{
				$part_status = 2;
			}
			elseif ($totalactive == 0 && $totalinstalled > 0)
			{
				$part_status = 0;
			}
			else
			{
				$part_status = 1;
			}
		}

		$totalconfig = $totalconfigs['module'][$e];

		$ifthistools = $tools[$e];
		$ent_code = $cfgentries[$e];
		$if_plg_standalone = $standalone[$e];
		$ifstruct = $struct[$e];

		$icofile = $cfg['extensions_dir'].'/'.$e.'/'.$e.'.png';

		$installed_ver = $installed_vers[$e];

		$L['info_name'] = '';
		$L['info_desc'] = '';
		if (file_exists(cot_langfile($e)))
		{
			include cot_langfile($e);
		}

		$t->assign(array(
			'ADMIN_EXTENSIONS_DETAILS_URL' => cot_url('admin', "t=extensions&m=details&e=$e"),
			'ADMIN_EXTENSIONS_NAME' => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
			'ADMIN_EXTENSIONS_CODE_X' => $e,
			'ADMIN_EXTENSIONS_DESCRIPTION' => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
			'ADMIN_EXTENSIONS_ICO' => (file_exists($icofile)) ? $icofile : '',
			'ADMIN_EXTENSIONS_EDIT_URL' => cot_url('admin', "t=config&n=edit&o=extension&e=$e"),
			'ADMIN_EXTENSIONS_TOTALCONFIG' => $totalconfig,
			'ADMIN_EXTENSIONS_PARTSCOUNT' => $info['Partscount'],
			'ADMIN_EXTENSIONS_STATUS' => $status[$part_status],
			'ADMIN_EXTENSIONS_VERSION' => $info['Version'],
			'ADMIN_EXTENSIONS_VERSION_INSTALLED' => $installed_ver,
			'ADMIN_EXTENSIONS_VERSION_COMPARE' => version_compare($info['Version'], $installed_ver),
			'ADMIN_EXTENSIONS_RIGHTS_URL' => cot_url('admin', "t=rightsbyitem&e=$e&io=a"),
			'ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS' => cot_url('admin', "e=$e"),
			'ADMIN_EXTENSIONS_JUMPTO_URL' => cot_url('index', 'e='.$e),
			'ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT' => cot_url('admin', "t=structure&e=$e"),
			'ADMIN_EXTENSIONS_ODDEVEN' => cot_build_oddeven($i)
		));
		/* === Hook - Part2 : Include === */
		foreach ($extp as $ext)
		{
			include $ext;
		}
		/* ===== */
		$t->parse('MAIN.SECTION.ROW');
	}
}
$t->assign(array(
	'ADMIN_EXTENSIONS_CNT_EXTP' => $cnt_extp
));
$t->parse('MAIN.SECTION');

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.extensions.tags') as $ext)
{
	include $ext;
}
/* ===== */
$t->parse('MAIN');
$adminmain = $t->text('MAIN');
