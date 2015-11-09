<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Trashcan interface
 *
 * @package trashcan
 * @version 0.9.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('trashcan', 'any');
cot_block($usr['isadmin']);

require_once cot_incfile('users', 'functions');
cot_extension_active('page') && require_once cot_incfile('page', 'functions');
cot_extension_active('forums') && require_once cot_incfile('forums', 'functions');
$cfg['comments'] && require_once cot_incfile('comments', 'functions');

require_once cot_incfile('trashcan');
require_once cot_langfile('trashcan');

$adminsubtitle = $L['Trashcan'];

$id = cot_import('id', 'G', 'INT');
list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);
$info = ($a == 'info') ? 1 : 0;

/* === Hook === */
foreach (cot_getextensions('trashcan.admin.first') as $ext)
{
	include $ext;
}
/* ===== */

if($a == 'wipe')
{
	cot_check_xg();
	/* === Hook === */
	foreach (cot_getextensions('trashcan.admin.wipe') as $ext)
	{
		include $ext;
	}
	/* ===== */
	cot_trash_delete($id);
	cot_message('adm_trashcan_deleted');
	cot_redirect(cot_url('admin', 't=other&p=trashcan', '', true));
}
elseif($a == 'wipeall')
{
	cot_check_xg();
	/* === Hook === */
	foreach (cot_getextensions('trashcan.admin.wipeall') as $ext)
	{
		include $ext;
	}
	/* ===== */
	$sql = $db->query("TRUNCATE $db_trash");

	cot_message('adm_trashcan_prune');
	cot_redirect(cot_url('admin', 't=other&p=trashcan', '', true));
}
elseif($a == 'restore')
{
	cot_check_xg();
	/* === Hook === */
	foreach (cot_getextensions('trashcan.admin.restore') as $ext)
	{
		include $ext;
	}
	/* ===== */
	cot_trash_restore($id);

	cot_message('adm_trashcan_restored');
	cot_redirect(cot_url('admin', 't=other&p=trashcan', '', true));
}

$tr_t = new XTemplate(cot_tplfile(($info) ? 'trashcan.info.admin' : 'trashcan.admin'));
$totalitems = (int)$db->query("SELECT COUNT(*) FROM $db_trash WHERE tr_parentid=0")->fetchColumn();
$pagenav = cot_pagenav('admin', 't=other&p=trashcan', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql_query = ($info) ? "AND tr_id=$id LIMIT 1" : "ORDER by tr_id DESC LIMIT $d, ".$cfg['maxrowsperpage'];
$sql = $db->query("SELECT t.*, u.user_name FROM $db_trash AS t
	LEFT JOIN $db_users AS u ON t.tr_trashedby=u.user_id
	WHERE tr_parentid=0 $sql_query");

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextensions('trashcan.admin.loop');
/* ===== */
foreach ($sql->fetchAll() as $row)
{
	$ii++;
	switch($row['tr_type'])
	{
		case 'comment':
			$icon = $R['admin_icon_comments'];
			$typestr = $L['Comment'];
			$enabled = cot_extension_active('comments') ? 1 : 0;
			break;

		case 'forumpost':
			$icon = $R['admin_icon_forums_posts'];
			$typestr = $L['Post'];
			$enabled = cot_extension_active('forums') ? 1 : 0;
			break;

		case 'forumtopic':
			$icon = $R['admin_icon_forums_topics'];
			$typestr = $L['Topic'];
			$enabled = cot_extension_active('forums') ? 1 : 0;
			break;

		case 'page':
			$icon = $R['admin_icon_page'];
			$typestr = $L['Page'];
			$enabled =cot_extension_active('page') ? 1 : 0;
			break;

		case 'user':
			$icon = $R['admin_icon_user'];
			$typestr = $L['User'];
			$enabled = 1;
			break;

		default:
			$icon = $R['admin_icon_tools'];
			$typestr = $row['tr_type'];
			$enabled = 1;
			break;
	}

	$tr_t->assign(array(
		'ADMIN_TRASHCAN_DATE' => cot_date('datetime_medium', $row['tr_date']),
		'ADMIN_TRASHCAN_DATE_STAMP' => $row['tr_date'],
		'ADMIN_TRASHCAN_TYPESTR_ICON' => $icon,
		'ADMIN_TRASHCAN_TYPESTR' => $typestr,
		'ADMIN_TRASHCAN_TITLE' => htmlspecialchars($row['tr_title']),
		'ADMIN_TRASHCAN_TRASHEDBY' => ($row['tr_trashedby'] == 0) ? $L['System'] : cot_build_user($row['tr_trashedby'], htmlspecialchars($row['user_name'])),
		'ADMIN_TRASHCAN_ROW_WIPE_URL' => cot_url('admin', 't=other&p=trashcan&a=wipe&id='.$row['tr_id'].'&d='.$durl.'&'.cot_xg()),
		'ADMIN_TRASHCAN_ROW_RESTORE_URL' => cot_url('admin', 't=other&p=trashcan&a=restore&id='.$row['tr_id'].'&d='.$durl.'&'.cot_xg()),
		'ADMIN_TRASHCAN_ROW_INFO_URL' => cot_url('admin', 't=other&p=trashcan&a=info&id='.$row['tr_id']),
		'ADMIN_TRASHCAN_ROW_RESTORE_ENABLED' => $enabled,
	));

	/* === Hook - Part2 : Include === */
	foreach ($extp as $ext)
	{
		include $ext;
	}
	/* ===== */
	if($info)
	{
		$out['breadcrumbs'][] = array(cot_url('admin', 't=other&p=trashcan&a=info&id='.$id), $row['tr_title']);
		$data = unserialize($row['tr_datas']);
		{
			foreach($data as $key => $val)
			{
				$tr_t->assign(array(
					'ADMIN_TRASHCAN_INFO_ROW' => htmlspecialchars($key),
					'ADMIN_TRASHCAN_INFO_VALUE' => $val,
				));
				$tr_t->parse('MAIN.TRASHCAN_ROW.TRASHCAN_INFOROW');
			}
		}

	}
	$tr_t->parse('MAIN.TRASHCAN_ROW');
}
if($ii == 0)
{
	$tr_t->parse('MAIN.TRASHCAN_EMPTY');
}



$tr_t->assign(array(
	'ADMIN_TRASHCAN_CONF_URL' => cot_url('admin', 't=config&n=edit&o=extension&p=trashcan'),
	'ADMIN_TRASHCAN_WIPEALL_URL' => cot_url('admin', 't=other&p=trashcan&a=wipeall&'.cot_xg()),
	'ADMIN_TRASHCAN_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_TRASHCAN_PAGNAV' => $pagenav['main'],
	'ADMIN_TRASHCAN_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_TRASHCAN_TOTALITEMS' => $totalitems,
	'ADMIN_TRASHCAN_COUNTER_ROW' => $ii,
	'ADMIN_TRASHCAN_PAGESQUEUED' => $pagesqueued,
	'ADMIN_TRASHCAN_BREADCRUMBS' =>  cot_breadcrumbs($out['breadcrumbs'], false),
));


cot_display_messages($tr_t);

/* === Hook  === */
foreach (cot_getextensions('trashcan.admin.tags') as $ext)
{
	include $ext;
}
/* ===== */

$tr_t->parse('MAIN');

$adminmain = $tr_t->text('MAIN');
