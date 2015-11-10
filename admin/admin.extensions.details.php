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

$t = new XTemplate(cot_tplfile('admin.extensions', 'system'));

$out['breadcrumbs'][] = array (cot_url('admin', 't=extensions'), $L['Extensions']);
$adminsubtitle = $L['Extensions'];

$part = cot_import('part', 'G', 'TXT');
$sort = cot_import('sort', 'G', 'ALP');

if (empty($e))
{
	cot_die();
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


$ext_info = $cfg['extensions_dir'] . '/' . $e . '/' . $e . '.setup.php';
$exists = file_exists($ext_info);
if ($exists)
{
	$old_ext_format = false;
	$info = cot_infoget($ext_info, 'COT_EXT');
}
else
{
	$info = array(
		'Name' => $e
	);
}
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

if ($exists)
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

	$info['Auth_members'] = cot_auth_getvalue($info['Auth_members']);
	$info['Lock_members'] = cot_auth_getvalue($info['Lock_members']);
	$info['Auth_guests'] = cot_auth_getvalue($info['Auth_guests']);
	$info['Lock_guests'] = cot_auth_getvalue($info['Lock_guests']);
}
else
{
	$row = $db->query("SELECT * FROM $db_core WHERE ct_code = '$e'")->fetch();
	$info['Name'] = $row['ct_title'];
	$info['Version'] = $row['ct_version'];
}

$out['breadcrumbs'][] = array(cot_url('admin', "t=extensions&m=details&e=$e"), $info['Name']);

$isinstalled = cot_extension_installed($e);

$sql = $db->query("SELECT COUNT(*) FROM $db_config WHERE config_owner='extension' AND config_cat='$e' AND config_type != " . COT_CONFIG_TYPE_HIDDEN);
$totalconfig = $sql->fetchColumn();

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
		if (sizeof($not_registred) || sizeof($deleted))
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

		if(!empty($info_file['Error']))
		{
			$t->assign(array(
				'ADMIN_EXTENSIONS_DETAILS_ROW_X' => $x,
				'ADMIN_EXTENSIONS_DETAILS_ROW_ERROR' => $info_file['Error']
			));
			$t->parse('MAIN.ROW_ERROR_PART');
		}
		else
		{
			$sql = $db->query("SELECT ext_active, ext_id FROM $db_extension_hooks
				WHERE ext_code='$e' AND ext_part='".$info_part."' LIMIT 1");

			if($row = $sql->fetch())
			{
				$info_file['Status'] = $row['ext_active'];
			}
			else
			{
				$info_file['Status'] = 3;
			}

			if(empty($info_file['Tags']))
			{
				$t->assign(array(
					'ADMIN_EXTENSIONS_DETAILS_ROW_I_1' => $i+1,
					'ADMIN_EXTENSIONS_DETAILS_ROW_PART' => $info_part
				));
				$t->parse('MAIN.ROW_ERROR_TAGS');
			}
			else
			{
				$taggroups = explode(';', $info_file['Tags']);
				foreach ($taggroups as $taggroup)
				{
					$line = explode(':', $taggroup);
					$line[0] = trim($line[0]);
					$tplbase = explode('.', preg_replace('#\.tpl$#i', '', $line[0]));
					// Detect template container type
					if (in_array($tplbase[0], array('admin', 'users')))
					{
						$tpltype = 'system';
					}
					else
					{
						$tpltype = 'extension';
					}
					$tags = explode(',', $line[1]);
					$text_file = cot_tplfile($tplbase, $tpltype);
					$listtags = $text_file.' :<br />';
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
					$tpl_check = new XTemplate($text_file);
					$tpl_tags = $tpl_check->getTags();
					unset($tpl_tags[array_search('PHP', $tpl_tags)]);
					foreach($tags as $k => $v)
					{
						if(mb_substr(trim($v), 0, 1) == '{')
						{
							$tag = str_replace(array('{','}'),'',$v);
							$found = in_array($tag, $tpl_tags);
							$listtags .= $v.' : ';
							$listtags .= $found_txt[$found].'<br />';
						}
						else
						{
							$listtags .= $v.'<br />';
						}
					}

					$t->assign(array(
						'ADMIN_EXTENSIONS_DETAILS_ROW_I_1' => $i+1,
						'ADMIN_EXTENSIONS_DETAILS_ROW_PART' => $info_part,
						'ADMIN_EXTENSIONS_DETAILS_ROW_FILE' => $line[0].' :<br />',
						'ADMIN_EXTENSIONS_DETAILS_ROW_LISTTAGS' => $listtags,
						//'ADMIN_EXTENSIONS_DETAILS_ROW_TAGS_ODDEVEN' => cot_build_oddeven($ii)
					));
					$t->parse('MAIN.ROW_TAGS');
				}
			}

			$info_order = empty($info_file['Order']) ? COT_EXT_DEFAULT_ORDER : $info_file['Order'];
			$t->assign(array(
				'ADMIN_EXTENSIONS_DETAILS_ROW_I_1' => $i+1,
				'ADMIN_EXTENSIONS_DETAILS_ROW_PART' => $info_part,
				'ADMIN_EXTENSIONS_DETAILS_ROW_FILE' => $x,
				'ADMIN_EXTENSIONS_DETAILS_ROW_HOOKS' => implode('<br />',explode(',',$info_file['Hooks'])),
				'ADMIN_EXTENSIONS_DETAILS_ROW_ORDER' => $info_order,
				'ADMIN_EXTENSIONS_DETAILS_ROW_STATUS' => $status[$info_file['Status']],
				//'ADMIN_EXTENSIONS_DETAILS_ROW_PART_ODDEVEN' => cot_build_oddeven($ii)
			));

			if ($info_file['Status'] == 3)
			{
				$t->parse('MAIN.ROW_PART.ROW_PART_NOTINSTALLED');
			}
			if ($info_file['Status'] != 3 && $row['ext_active'] == 1)
			{
				$t->assign('ADMIN_EXTENSIONS_DETAILS_ROW_PAUSEPART_URL',
					cot_url('admin', "t=extensions&m=details&e=$e&a=pausepart&part=".$info_part));
				$t->parse('MAIN.ROW_PART.ROW_PART_PAUSE');
			}
			if ($info_file['Status'] != 3 && $row['ext_active'] == 0)
			{
				$t->assign('ADMIN_EXTENSIONS_DETAILS_ROW_UNPAUSEPART_URL',
					cot_url('admin', "t=extensions&m=details&e=$e&a=unpausepart&part=".$info_part));
				$t->parse('MAIN.ROW_PART.ROW_PART_UNPAUSE');
			}

			/* === Hook - Part2 : Include === */
			foreach ($extp as $ext)
			{
				include $ext;
			}
			/* ===== */
			$t->parse('MAIN.ROW_PART');
		}
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

// Universal tags
$t->assign(array(
	'ADMIN_EXTENSIONS_NAME' => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
	'ADMIN_EXTENSIONS_CODE' => $e,
	'ADMIN_EXTENSIONS_ICO' => (file_exists($icofile)) ? $icofile : '',
	'ADMIN_EXTENSIONS_DESCRIPTION' => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
	'ADMIN_EXTENSIONS_VERSION' => $info['Version'],
	'ADMIN_EXTENSIONS_VERSION_INSTALLED' => $installed_ver,
	'ADMIN_EXTENSIONS_VERSION_COMPARE' => version_compare($info['Version'], $installed_ver),
	'ADMIN_EXTENSIONS_DATE' => $info['Date'],
	'ADMIN_EXTENSIONS_CONFIG_URL' => cot_url('admin', "t=config&n=edit&o=extension&p=$e"),
	'ADMIN_EXTENSIONS_JUMPTO_URL_TOOLS' => $tools,
	'ADMIN_EXTENSIONS_JUMPTO_URL' => $standalone,
	'ADMIN_EXTENSIONS_JUMPTO_URL_STRUCT' => $struct,
	'ADMIN_EXTENSIONS_TOTALCONFIG' => $totalconfig,
	'ADMIN_EXTENSIONS_INSTALL_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=install"),
	'ADMIN_EXTENSIONS_UPDATE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=update"),
	'ADMIN_EXTENSIONS_UNINSTALL_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=uninstall"),
	'ADMIN_EXTENSIONS_UNINSTALL_CONFIRM_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=uninstall&x={$sys['xk']}"),
	'ADMIN_EXTENSIONS_PAUSE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=pause"),
	'ADMIN_EXTENSIONS_UNPAUSE_URL' => cot_url('admin', "t=extensions&m=details&e=$e&a=unpause")
));

if ($exists)
{
	// Tags for existing exts
	$t->assign(array(
		'ADMIN_EXTENSIONS_RIGHTS' => cot_url('admin', "t=rightsbyitem&ic=$e&io=a"),
		'ADMIN_EXTENSIONS_ADMRIGHTS_AUTH_GUESTS' => cot_auth_getmask($info['Auth_guests']),
		'ADMIN_EXTENSIONS_AUTH_GUESTS' => $info['Auth_guests'],
		'ADMIN_EXTENSIONS_ADMRIGHTS_LOCK_GUESTS' => cot_auth_getmask($info['Lock_guests']),
		'ADMIN_EXTENSIONS_LOCK_GUESTS' => $info['Lock_guests'],
		'ADMIN_EXTENSIONS_ADMRIGHTS_AUTH_MEMBERS' => cot_auth_getmask($info['Auth_members']),
		'ADMIN_EXTENSIONS_AUTH_MEMBERS' => $info['Auth_members'],
		'ADMIN_EXTENSIONS_ADMRIGHTS_LOCK_MEMBERS' => cot_auth_getmask($info['Lock_members']),
		'ADMIN_EXTENSIONS_LOCK_MEMBERS' => $info['Lock_members'],
		'ADMIN_EXTENSIONS_AUTHOR' => $info['Author'],
		'ADMIN_EXTENSIONS_COPYRIGHT' => $info['Copyright'],
		'ADMIN_EXTENSIONS_NOTES' => empty($L['info_notes']) ? $info['Notes'] : $L['info_notes'],
	));

	// Check and display dependencies
	$dependencies_satisfied = true;
	foreach (array('Requires', 'Recommends') as $dep_type)
	{
		if (!empty($info[$dep_type]))
		{
			$dep_obligatory = strpos($dep_type, 'Requires') === 0;
			$dep_module = strpos($dep_type, 'modules') !== false;


			foreach (explode(',', $info[$dep_type]) as $ext)
			{
				$ext = trim($ext);
				$dep_installed = cot_extension_installed($ext);
				if ($dep_obligatory)
				{
					$dep_class = $dep_installed ? 'highlight_green' : 'highlight_red';
					$dependencies_satisfied &= $dep_installed;
				}
				else
				{
					$dep_class = '';
				}

				$dep_ext_info = $cfg['extensions_dir'] . '/' . $ext . '/' . $ext . '.setup.php';
				if (file_exists($dep_ext_info))
				{
					$dep_info = cot_infoget($dep_ext_info, 'COT_EXT');
				}
				else
				{
					$dep_info = array(
						'Name' => $ext
					);
				}
				$t->assign(array(
					'ADMIN_EXTENSIONS_DEPENDENCIES_ROW_CODE' => $ext,
					'ADMIN_EXTENSIONS_DEPENDENCIES_ROW_NAME' => $dep_info['Name'],
					'ADMIN_EXTENSIONS_DEPENDENCIES_ROW_URL' => ($dep_module && file_exists($cfg['extensions_dir'] . '/' . $ext)) ? cot_url('admin', "t=extensions&m=details&e=$ext") : '#',
					'ADMIN_EXTENSIONS_DEPENDENCIES_ROW_CLASS' => $dep_class
				));
				$t->parse('MAIN.DEPENDENCIES.DEPENDENCIES_ROW');
			}
			$t->assign(array(
				'ADMIN_EXTENSIONS_DEPENDENCIES_TITLE' => $L['ext_' . strtolower($dep_type)]
			));
			$t->parse('MAIN.DEPENDENCIES');
		}
	}
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
$t->parse('MAIN');
$adminmain = $t->text('MAIN');
