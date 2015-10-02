<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Administration panel - Manager of comments
 *
 * @package comments
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('comments', 'any');
cot_block($usr['isadmin']);

require_once cot_incfile('comments', 'functions');

$t = new XTemplate(cot_tplfile('comments.admin'));

$adminsubtitle = $L['comments_comments'];

list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

$admin_comments_join_fields = '';
$admin_comments_join_tables = '';
$admin_comments_join_where = '';

/* === Hook  === */
foreach (cot_getextensions('admin.comments.first') as $ext)
{
	include $ext;
}
/* ===== */

if ($a == 'delete')
{
	cot_check_xg();
	$db->delete($db_com, "com_id=$id");

	$adminwarnings = ($sql) ? $L['adm_comm_already_del'] : $L['Error'];
}

$is_adminwarnings = isset($adminwarnings);

$totalitems = $db->countRows($db_com);

$pagenav = cot_pagenav('admin', 't=other&p=comments', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

if (cot_extension_active('page'))
{
	require_once cot_incfile('page', 'functions');
	$admin_comments_join_fields = ", p.*";
	$admin_comments_join_tables = " LEFT JOIN $db_pages AS p
		ON c.com_area = 'page' AND c.com_code = p.page_id";
}

$sql = $db->query("SELECT c.* $admin_comments_join_fields
	FROM $db_com AS c $admin_comments_join_tables
	WHERE 1 $admin_comments_join_where
	ORDER BY com_id DESC LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextensions('admin.comments.loop');
/* ===== */
foreach ($sql->fetchAll() as $row)
{
	$row['com_text'] = htmlspecialchars(cot_cutstring(strip_tags($row['com_text']), 40));
	$row['com_type'] = mb_substr($row['com_code'], 0, 1);
	$row['com_value'] = $row['com_code'];

	switch ($row['com_area'])
	{
		case 'page':
			$row['com_url'] = cot_url('page', "c=".$row['page_cat']."&id=".$row['com_code'], "#c".$row['com_id']);
		break;

		case 'users':
			$row['com_url'] = cot_url('users', 'm=details&id='.$row['com_value'], '#c'.$row['com_id']);
		break;

		case 'polls':
			$row['com_url'] = cot_url('polls', 'id='.$row['com_value']."&comments=1", '#c'.$row['com_id']);
		break;


		default:
			$row['com_url'] = '';
		break;
	}

	$t->assign(array(
		'ADMIN_COMMENTS_ITEM_DEL_URL' => cot_url('admin', 't=other&p=comments&a=delete&id='.$row['com_id'].'&'.cot_xg()),
		'ADMIN_COMMENTS_ITEM_ID' => $row['com_id'],
		'ADMIN_COMMENTS_CODE' => $row['com_code'],
		'ADMIN_COMMENTS_AREA' => $row['com_area'],
		'ADMIN_COMMENTS_AUTHOR' => $row['com_author'],
		'ADMIN_COMMENTS_DATE' => cot_date('datetime_medium', $row['com_date']),
		'ADMIN_COMMENTS_DATE_STAMP' => $row['com_date'],
		'ADMIN_COMMENTS_TEXT' => $row['com_text'],
		'ADMIN_COMMENTS_URL' => $row['com_url'],
		'ADMIN_COMMENTS_ODDEVEN' => cot_build_oddeven($ii)
	));

	if (isset($cot_extrafields[$db_com]))
	{
		foreach ($cot_extrafields[$db_com] as $exfld)
		{
			$tag = mb_strtoupper($exfld['field_name']);
			$t->assign(array(
				'ADMIN_COMMENTS_' . $tag . '_TITLE' => isset($L['comments_' . $exfld['field_name'] . '_title']) ? $L['comments_' . $exfld['field_name'] . '_title'] : $exfld['field_description'],
				'ADMIN_COMMENTS_' . $tag => cot_build_extrafields_data('comments', $exfld, $row['com_'.$exfld['field_name']]),
				'ADMIN_COMMENTS_' . $tag . '_VALUE' => $row['com_'.$exfld['field_name']],
			));
		}
	}

	/* === Hook - Part2 : Include === */
	foreach ($extp as $ext)
	{
		include $ext;
	}
	/* ===== */
	$t->parse('MAIN.ADMIN_COMMENTS_ROW');
	$ii++;
}

$t->assign(array(
	'ADMIN_COMMENTS_CONFIG_URL' => cot_url('admin', 't=config&n=edit&o=extension&p=comments'),
	'ADMIN_COMMENTS_ADMINWARNINGS' => $adminwarnings,
	'ADMIN_COMMENTS_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_COMMENTS_PAGNAV' => $pagenav['main'],
	'ADMIN_COMMENTS_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_COMMENTS_TOTALITEMS' => $totalitems,
	'ADMIN_COMMENTS_COUNTER_ROW' => $ii,
	'ADMIN_COMMENTS_BREADCRUMBS' => cot_breadcrumbs($adminpath, false),	
));

/* === Hook  === */
foreach (cot_getextensions('admin.comments.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');

