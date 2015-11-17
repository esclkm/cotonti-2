<?php

/**
 * Extension administration
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

require_once cot_incfile('system', 'auth');

$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
$adminsubtitle = $L['Extensions'];

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
$sort_urlp = $s == 'cat' ? '&s=cat' : '';

// Filter/sort tags


// Prefetch common data to save SQL queries
$totalconfigs = array();
foreach ($db->query("SELECT COUNT(*) AS cnt, config_owner, config_cat
		FROM $db_config WHERE config_type != ".COT_CONFIG_TYPE_HIDDEN."
		GROUP BY config_owner, config_cat")->fetchAll() as $row)
{
	$totalconfigs[$row['config_owner']] = (int)$row['cnt'];
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

if ($s == 'cat')
{
	uasort($extensions, 'cot_extension_catcmp');
}
else
{
	uasort($extensions, 'cot_extension_namecmp');
}

$standalone = array();
$tools = array();
$struct = array();
$sql3 = $db->query("SELECT ext_code, ext_hook FROM $db_extension_hooks 
	WHERE ext_hook='standalone' OR ext_hook='admin' OR ext_hook='admin.structure.first'");
while ($row3 = $sql3->fetch())
{
	$row3['ext_hook'] == 'standalone' && $standalone[$row3['ext_code']] = TRUE;
	$row3['ext_hook'] == 'admin' && $tools[$row3['ext_code']] = TRUE;
	$row3['ext_hook'] == 'admin.structure.first' && $struct[$row3['ext_code']] = TRUE;
}
$sql3->closeCursor();

$t = new FTemplate(cot_tplfile('admin.extensions', 'system'));

$ext_cat = array();
$ext_list = array();

/* === Hook - Part1 : Set === */
$extp = cot_getextensions("admin.extensions.extensions.list.loop");
/* ===== */
foreach ($extensions as $ext_code => $ext_info)
{
	$category = ($s == 'cat') ? $ext_info['Category'] : 'all';

	$totalactive = $totalactives[$ext_code];
	$totalinstalled = $totalinstalleds[$ext_code];

	if (!isset($installed_vers[$ext_code]))
	{
		$part_status = 'notinstalled';
	}
	else
	{
		$ext_info['Partscount'] = $totalinstalled;
		if (isset($ext_info['NotFound']))
		{
			$part_status = 'missing';
		}
		elseif ($totalinstalled > $totalactive && $totalactive > 0)
		{
			$part_status = 'partrunning';
		}
		elseif ($totalactive == 0 && $totalinstalled > 0)
		{
			$part_status = 'paused';
		}
		else
		{
			$part_status = 'running';
		}
	}

	$icofile = $cfg['extensions_dir'].'/'.$ext_code.'/'.$ext_code.'.png';


	$L['info_name'] = '';
	$L['info_desc'] = '';
	if (file_exists(cot_langfile($ext_code)))
	{
		require_once cot_langfile($ext_code);
	}
	$ext_tags = [

		'NAME' => empty($L['info_name']) ? $ext_info['Name'] : $L['info_name'],
		'CODE' => $ext_code,
		'DESCRIPTION' => empty($L['info_desc']) ? $ext_info['Description'] : $L['info_desc'],
		'ICO' => (file_exists($icofile)) ? $icofile : '',	
		'TOTALCONFIG' => $totalconfigs[$ext_code],
		'PARTSCOUNT' => (int)$ext_info['Partscount'],
		'STATUS' => $part_status,
		'VERSION' => $ext_info['Version'],
		'VERSION_INSTALLED' => $installed_vers[$ext_code],
		'VERSION_COMPARE' => version_compare($ext_info['Version'], $installed_vers[$ext_code]),
		'URL_CONFIG' => $totalconfigs[$ext_code] ? cot_url('admin', "t=config&m=edit&e=$ext_code") : '',
		'URL_DETAILS' => cot_url('admin', "t=extensions&m=details&e=$ext_code"),		
		'URL_RIGHTS' => cot_url('admin', "t=rightsbyitem&e=$ext_code&io=a"),
		'URL_ADMIN' => $tools[$ext_code] ? cot_url('admin', "e=$ext_code") : '',
		'URL_OPEN' => $standalone[$ext_code] ? cot_url('index', 'e='.$ext_code) : '',
		'URL_STRUCT' => $struct[$ext_code] ? cot_url('admin', "t=structure&e=$ext_code") : '',
		'ERROR_MSG' => $ext_info['Error']
	];
	/* === Hook - Part2 : Include === */
	foreach ($extp as $ext)
	{
		include $ext;
	}
	/* ===== */
	$ext_cat[$category] = $L['ext_cat_'.$ext_info['Category']];
	$ext_list[$category][] = $ext_tags;
}

$t->assign(array(
	'ADMIN_EXT_HOOKS_URL' => cot_url('admin', 't=extensions&m=hooks'),
	'ADMIN_EXT_SORT_ALP_URL' => cot_url('admin', 't=extensions'.$only_installed_urlp),
	'ADMIN_EXT_SORT_ALP_SEL' => $s != 'cat',
	'ADMIN_EXT_SORT_CAT_URL' => cot_url('admin', 't=extensions&s=cat'.$only_installed_urlp),
	'ADMIN_EXT_SORT_CAT_SEL' => $s == 'cat',
	'ADMIN_EXT_ALL_EXTENSIONS_URL' => cot_url('admin', 't=extensions'.$sort_urlp),
	'ADMIN_EXT_ONLY_INSTALLED_URL' => cot_url('admin', 't=extensions'.$sort_urlp.$only_installed_toggle),
	'ADMIN_EXT_ONLY_INSTALLED_SEL' => $only_installed,
	'ADMIN_EXT_CATEGORIES' => $ext_cat,
	'ADMIN_EXT_EXTENSIONS' => $ext_list,
	'ADMIN_EXT_CNT_EXTP' => count($extensions),
	'ADMIN_EXT_CAT_ORDER' => ($s == 'cat')
));
cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.extensions.tags') as $ext)
{
	include $ext;
}
/* ===== */
$t->parse();
$adminmain = $t->text();
