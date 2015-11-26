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

$t = new FTemplate(cot_tplfile('admin.extensions.details', 'system'));

$out['breadcrumbs'][] = array (cot_url('admin', 't=extensions'), $L['Extensions']);
$adminsubtitle = $L['Extensions'];


$part = cot_import('part', 'G', 'TXT');

if (empty($e))
{
	cot_die();
}

$status[0] = 'paused';
$status[1] = 'running';
$status[2] = 'partrunning';
$status[3] = 'notinstalled';
$status[4] = 'missing';

/* === Hook === */
foreach (cot_getextensions('admin.extensions.first') as $ext)
{
	include $ext;
}
/* ===== */

$ext_info = $cfg['extensions_dir'] . '/' . $e . '/' . $e . '.setup.php';
$ext_setupfile_exists = file_exists($ext_info);
$ext_info = file_exists($ext_info) ? cot_infoget($ext_info, 'COT_EXT') : ['Name' => $e];

switch($a)
{
	case 'install':
		$installed_extensions = $db->query("SELECT ct_code FROM $db_core WHERE ct_extension = 0")->fetchAll(PDO::FETCH_COLUMN);
		$dependencies_satisfied = cot_extension_dependencies_statisfied($e, $installed_extensions);
		if ($dependencies_satisfied)
		{
			$result = cot_extension_install($e);
		}
	break;
	case 'update':
		$result = cot_extension_install($e, true, true);
		break;
	case 'uninstall':
		/* === Hook  === */
		foreach (cot_getextensions('admin.extensions.uninstall.first') as $ext)
		{
			include $ext;
		}
		/* ===== */
		if (cot_check_xg(false))
		{
			// Check if there are extensions installed depending on this one
			$dependencies_satisfied = true;
			$res = $db->query("SELECT ct_code FROM $db_core ORDER BY ct_code");
			foreach ($res->fetchAll() as $row)
			{
				$ext = $row['ct_code'];
				$dep_ext_info = $cfg['extensions_dir'] . '/' . $ext . '/' . $ext . '.setup.php';
				if (file_exists($dep_ext_info))
				{
					$dep_info = cot_infoget($dep_ext_info, 'COT_EXT');
					$dep_field = 'Requires';
					if (in_array($e, explode(',', $dep_info[$dep_field])))
					{
						cot_error(cot_rc('ext_dependency_uninstall_error', array('name' => $dep_info['Name'])));
						$dependencies_satisfied = false;
					}
				}
			}

			if ($dependencies_satisfied)
			{
				$result = cot_extension_uninstall($e);
			}
			$out['breadcrumbs'][] = $L['adm_opt_uninstall'];
		}
		else
		{
			$url = cot_url('admin', "t=extensions&m=details&e=$e&a=uninstall&x={$sys['xk']}");
			cot_message(cot_rc('ext_uninstall_confirm', array('url' => $url)), 'error');
			cot_redirect(cot_url('admin', "t=extensions&m=details&e=$e", '', true));
		}
	break;
	case 'pause':
		cot_extension_pause($e);
		cot_message('adm_paused');
	break;
	case 'unpause':
		cot_extension_resume($e);
		cot_message('adm_running');
	break;
	case 'pausepart':
		cot_extension_pause_hooks($e, $part);
		cot_message('adm_partstopped');
	break;
	case 'unpausepart':
		cot_extension_resume_hooks($e, $part);
		cot_message('adm_partrunning');
	break;
}
if (!empty($a))
{
	$db->update($db_users, array('user_auth' => ''), "user_auth != ''");
	if ($cache)
	{
		$cache->clear();
		cot_rc_consolidate();
	}
}

if ($ext_setupfile_exists)
{
	$parts = array();
	$handle = opendir($cfg['extensions_dir'] . '/' . $e);
	while($f = readdir($handle))
	{
		
		if (preg_match("#^$e(\.([\w\.]+))?.php$#", $f, $mt)
			&& !in_array($mt[2], $cot_ext_ignore_parts))
		{
			$parts[] = $f;
		}
	}
	closedir($handle);

	$ext_info['Auth_members'] = cot_auth_getvalue($ext_info['Auth_members']);
	$ext_info['Lock_members'] = cot_auth_getvalue($ext_info['Lock_members']);
	$ext_info['Auth_guests'] = cot_auth_getvalue($ext_info['Auth_guests']);
	$ext_info['Lock_guests'] = cot_auth_getvalue($ext_info['Lock_guests']);
}
else
{
	$row = $db->query("SELECT * FROM $db_core WHERE ct_code = '$e'")->fetch();
	$ext_info['Name'] = $row['ct_title'];
	$ext_info['Version'] = $row['ct_version'];
}

$out['breadcrumbs'][] = array(cot_url('admin', "t=extensions&m=details&e=$e"), $ext_info['Name']);

$ext_installed = cot_extension_installed($e);

$totalconfig = $db->query("SELECT COUNT(*) FROM $db_config WHERE config_owner='$e' AND config_type != " . COT_CONFIG_TYPE_HIDDEN)->fetchColumn();

$ext_parts = array();
$ext_tags = array();
if (count($parts) > 0)
{
	sort($parts);
	/* === Hook - Part1 : Set === */
	$extp = cot_getextensions('admin.extensions.details.part.loop');
	/* ===== */
	foreach ($parts as $i => $x)
	{
		$ext_file = $cfg['extensions_dir'] . '/' . $e . '/' . $x;
		$info_file = cot_infoget($ext_file, 'COT_EXT');
		$info_part = preg_match("#^$e\.([\w\.]+).php$#", $x, $mt) ? $mt[1] : 'main';
		$Hooks = explode(',', str_replace(' ', '', $info_file['Hooks']));
		// check for not registered Hooks
		$not_registred = array();
		foreach ($Hooks as $h)
		{
			$regsistred_by_hook = $cot_hooks[$h];
			if (is_array($regsistred_by_hook) && sizeof($regsistred_by_hook))
			{
				$found = false;
				foreach ($regsistred_by_hook as $reg_data)
				{
					if ($reg_data['ext_file'] == $e . '/' . $x)
					{
						$found = true;
						break;
					}
				}
				if (! $found)
				{
					array_push($not_registred, $h);
				}
			}
			else
			{
				array_push($not_registred, $h);
			}
		}

		$deleted = array();
		// checks for deleted Hooks
		foreach ($cot_hooks as $registered)
		{
			foreach ($registered as $reg_data)
			{
				if ($reg_data['ext_file'] == $e . '/' . $x)
				{
					if (!in_array($reg_data['ext_hook'], $Hooks)) array_push($deleted, $reg_data['ext_hook']);
				}
			}
		}
		if ($ext_installed && (sizeof($not_registred) || sizeof($deleted)))
		{
			$info_file['Error'] = $L['adm_hook_changed'];
			if (sizeof($not_registred))
			{
				$info_file['Error'] .= cot_rc('adm_hook_notregistered', array('hooks' => implode(', ', $not_registred)));
			}
			if (sizeof($deleted))
			{
				$info_file['Error'] .= cot_rc('adm_hook_notfound', array('hooks' => implode(', ', $deleted)));
			}

			$info_file['Error'] .= $L['adm_hook_updatenote'];
		}
		
		$ext_part["FILE"] = $x;
		
		if(!empty($info_file['Error']))
		{
			$ext_part['ERROR'] = $info_file['Error'];
		}
		else
		{
			$sql = $db->query("SELECT ext_active, ext_id FROM $db_extension_hooks
				WHERE ext_code='$e' AND ext_part='".$info_part."' LIMIT 1");

			$info_file['Status'] = ($row = $sql->fetch()) ? $row['ext_active'] : 3;


			if(!empty($info_file['Tags']))
			{
				$taggroups = explode(';', $info_file['Tags']);
				$listtags = array();
				foreach ($taggroups as $taggroup)
				{
					$line = explode(':', $taggroup);
					$line[0] = trim($line[0]);
					$tplbase = explode('.', preg_replace('#\.tpl$#i', '', $line[0]));
					// Detect template container type
					$tpltype = (in_array($tplbase[0], array('admin'))) ? 'system' : 'extension';

					$tags = explode(',', $line[1]);
					$text_file = cot_tplfile($tplbase, $tpltype);
					
					//TODO: cot_tplfile - add custom themes
					if ($cfg['xtpl_cache'])
					{ // clears cache if exists
						$cache_file = str_replace(array('./', '/'), '_', $text_file);
						$cache_path = $cfg['cache_dir'] . '/templates/' . pathinfo($cache_file, PATHINFO_FILENAME );
						$cache_files_ext = array('.tpl','.idx','.tags');
						foreach ($cache_files_ext as $ext)
						{
							if (file_exists($cache_path.$ext)) unlink($cache_path.$ext);
						}
					}
					
					$listtags[$line[0]] = array();
					foreach($tags as $k => $v)
					{
						$listtags[$line[0]][] = $v;
					}

					$ext_tag = [
						'PART' => $info_part,
						'LISTTAGS' => $listtags,
					];
					$t->parse('MAIN.ROW_TAGS');
				}
				$ext_tags[] = $ext_tag;
			}

			$info_order = empty($info_file['Order']) ? COT_EXT_DEFAULT_ORDER : $info_file['Order'];

			$ext_part['PART'] = $info_part;
			$ext_part['FILE'] = $x;
			$ext_part['HOOKS'] = implode('<br />',explode(',',$info_file['Hooks']));
			$ext_part['ORDER'] = $info_order;
			$ext_part['STATUS'] = $status[$info_file['Status']];


			if ($info_file['Status'] == 3)
			{
				$ext_part['NOTINSTALLED'] = 1;
			}
			if ($info_file['Status'] != 3 && $row['ext_active'] == 1)
			{
				$ext_part['PAUSEPART_URL'] = cot_url('admin', "t=extensions&m=details&e=$e&a=pausepart&part=".$info_part);
			}
			if ($info_file['Status'] != 3 && $row['ext_active'] == 0)
			{
				$ext_part['UNPAUSEPART_URL'] = cot_url('admin', "t=extensions&m=details&e=$e&a=unpausepart&part=".$info_part);
			}

			/* === Hook - Part2 : Include === */
			foreach ($extp as $ext)
			{
				include $ext;
			}
			/* ===== */
			
		}
		$ext_parts[] = $ext_part;
	}
}

$L['info_name'] = '';
$L['info_desc'] = '';
$L['info_notes'] = '';
if (file_exists(cot_langfile($e)))
{
	include cot_langfile($e);
}
$icofile = $cfg['extensions_dir'] . '/' . $e . '/' . $e . '.png';

// Search admin parts, standalone parts, struct
if( $db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='standalone' AND ext_code='$e' LIMIT 1")->rowCount() > 0)
{
	$standalone = cot_url('index', 'e=' . $e);
}

if($db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='admin' AND ext_code='$e' AND ext_active = 1 LIMIT 1")->rowCount() > 0)
{
	$tools = cot_url('admin', "e=$e");
}

if($db->query("SELECT ext_code FROM $db_extension_hooks WHERE ext_hook='admin.structure.first' AND ext_code='$e' LIMIT 1")->rowCount() > 0)
{
	$struct = cot_url('admin', "t=structure&e=$e");
}

$installed_ver = $db->query("SELECT ct_version FROM $db_core WHERE ct_code = '$e'")->fetchColumn();

if($ext_installed)
{
	$extra_blacklist = array($db_auth, $db_cache, $db_cache_bindings, $db_core, $db_updates, $db_logger, $db_online, $db_extra_fields, $db_config, $db_plugins);
	$extra_whitelist = [
		$db_structure => [
			'name' => $db_structure,
			'caption' => $L['Categories'],
			'type' => 'system',
			'code' => 'structure',
			'tags' => [
				'page.list.tpl' => '{LIST_ROWCAT_XXXXX}, {LIST_CAT_XXXXX}',
				'page.list.group.tpl' => '{LIST_ROWCAT_XXXXX}, {LIST_CAT_XXXXX}',
				'page.tpl' => '{PAGE_CAT_XXXXX}, {PAGE_CAT_XXXXX_TITLE}',
				'admin.structure.inc.tpl' => ''
				]
			]
		];
	/* === Hook === */
	foreach (cot_getextensions('admin.extrafields.first') as $pl)
	{
		include $pl;
	}
	/* ===== */
	$extensions_extflds = array();

	foreach ($extra_whitelist as $key => $val)
	{
		if($e == $val['code'])
		{
			$extensions_extflds[] = array(
				'name' => $val['name'],
				'caption' => $val['caption'],
				'url' => cot_url('admin', 't=extrafields&n='.$val['name'])					
			);
		}
	}

	unset($extra_blacklist);
	unset($extra_whitelist);	
}
// Universal tags
$t->assign(array(
	'ADMIN_EXT_NAME' => empty($L['info_name']) ? $ext_info['Name'] : $L['info_name'],
	'ADMIN_EXT_CODE' => $e,
	'ADMIN_EXT_ICO' => (file_exists($icofile)) ? $icofile : '',
	'ADMIN_EXT_DESCRIPTION' => empty($L['info_desc']) ? $ext_info['Description'] : $L['info_desc'],
	'ADMIN_EXT_VERSION' => $ext_info['Version'],
	'ADMIN_EXT_VERSION_INSTALLED' => $installed_ver,
	'ADMIN_EXT_VERSION_COMPARE' => version_compare($ext_info['Version'], $installed_ver),
	'ADMIN_EXT_DATE' => $ext_info['Date'],
	'ADMIN_EXT_CONFIG_URL' => cot_url('admin', "t=config&m=edit&e=$e"),
	'ADMIN_EXT_JUMPTO_URL_TOOLS' => $tools,
	'ADMIN_EXT_JUMPTO_URL' => $standalone,
	'ADMIN_EXT_JUMPTO_URL_STRUCT' => $struct,
	'ADMIN_EXT_JUMPTO_EXFLDS' => $extensions_extflds,
	'ADMIN_EXT_TOTALCONFIG' => $totalconfig,
	'ADMIN_EXT_INSTALL_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=install"),
	'ADMIN_EXT_UPDATE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=update"),
	'ADMIN_EXT_UNINSTALL_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=uninstall"),
	'ADMIN_EXT_UNINSTALL_CONFIRM_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=uninstall&x={$sys['xk']}"),
	'ADMIN_EXT_PAUSE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=pause"),
	'ADMIN_EXT_UNPAUSE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=unpause"),
	'ADMIN_EXT_ISINSTALLED' => $ext_installed,
	'ADMIN_EXT_EXIST' => $ext_setupfile_exists,	
	'ADMIN_EXT_PARTS' => $ext_parts,	
	'ADMIN_EXT_TAGS' => $ext_tags,		
));

if ($ext_setupfile_exists)
{
	// Check and display dependencies
	$dependencies_satisfied = true;
	$requires = array();
	$recommends = array();
	foreach (array('Requires', 'Recommends') as $dep_type)
	{
		if (!empty($ext_info[$dep_type]))
		{
			foreach (explode(',', $ext_info[$dep_type]) as $ext)
			{
				$ext = trim($ext);
				$dep_installed = cot_extension_installed($ext);
				
				$dep_class = 'default';
				if ($dep_type == 'Requires')
				{
					$dep_class = $dep_installed ? 'success' : 'danger';
					$dependencies_satisfied &= $dep_installed;
				}

				$dep_ext_info = $cfg['extensions_dir'] . '/' . $ext . '/' . $ext . '.setup.php';
				$dep_info = (file_exists($dep_ext_info)) ? cot_infoget($dep_ext_info, 'COT_EXT') : ['Name' => $ext];

				$dep_ext = array(
					'CODE' => $ext,
					'NAME' => $dep_info['Name'],
					'URL' => (file_exists($cfg['extensions_dir'] . '/' . $ext)) ? cot_url('admin', "t=extensions&m=details&e=$ext") : '',
					'CLASS' => $dep_class
				);
				if($dep_type == 'Requires')
				{
					$requires[] = $dep_ext;
				}
				else
				{
					$recommends[] = $dep_ext;
				}
			}
		}
	}
	
	// Tags for existing exts
	$t->assign(array(
		'ADMIN_EXT_REQUIRES' => $requires,
		'ADMIN_EXT_RECOMMENDS' => $recommends,
		'ADMIN_EXT_RIGHTS' => cot_url('admin', "t=rightsbyitem&ic=$e&io=a"),
		'ADMIN_EXT_ADMRIGHTS_AUTH_GUESTS' => cot_auth_getmask($ext_info['Auth_guests']),
		'ADMIN_EXT_AUTH_GUESTS' => $ext_info['Auth_guests'],
		'ADMIN_EXT_ADMRIGHTS_LOCK_GUESTS' => cot_auth_getmask($ext_info['Lock_guests']),
		'ADMIN_EXT_LOCK_GUESTS' => $ext_info['Lock_guests'],
		'ADMIN_EXT_ADMRIGHTS_AUTH_MEMBERS' => cot_auth_getmask($ext_info['Auth_members']),
		'ADMIN_EXT_AUTH_MEMBERS' => $ext_info['Auth_members'],
		'ADMIN_EXT_ADMRIGHTS_LOCK_MEMBERS' => cot_auth_getmask($ext_info['Lock_members']),
		'ADMIN_EXT_LOCK_MEMBERS' => $ext_info['Lock_members'],
		'ADMIN_EXT_AUTHOR' => $ext_info['Author'],
		'ADMIN_EXT_COPYRIGHT' => $ext_info['Copyright'],
		'ADMIN_EXT_NOTES' => empty($L['info_notes']) ? $ext_info['Notes'] : $L['info_notes'],
	));
}
/* === Hook  === */
foreach (cot_getextensions('admin.extensions.details') as $ext)
{
	include $ext;
}
/* ===== */


cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.extensions.tags') as $ext)
{
include $ext;
}
/* ===== */
$t->parse();
$adminmain = $t->text();
