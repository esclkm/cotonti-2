<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Administration panel - Manager of ratings
 *
 * @package ratings
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('ratings', 'any');
cot_block($usr['isadmin']);

require_once cot_incfile('ratings', 'functions');

$t = new XTemplate(cot_tplfile('ratings.admin'));

$adminsubtitle = $L['Ratings'];

$id = cot_import('id','G','TXT');
list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

/* === Hook  === */
foreach (cot_getextensions('admin.ratings.first') as $ext)
{
	include $ext;
}
/* ===== */

if($a == 'delete')
{
	cot_check_xg();
	$db->delete($db_ratings, 'rating_code = ' . $db->quote($id));
	$db->delete($db_rated, 'rated_code = ' . $db->quote($id));

	cot_message('adm_ratings_already_del');
}


$totalitems = $db->countRows($db_ratings);
$pagenav = cot_pagenav('admin', 't=other&p=ratings', $d, $totalitems, $cfg['maxrowsperpage'], 'd', '', $cfg['jquery'] && $cfg['turnajax']);

$sql = $db->query("SELECT * FROM $db_ratings WHERE 1 ORDER by rating_id DESC LIMIT $d, ".$cfg['maxrowsperpage']);

$ii = 0;
$jj = 0;
/* === Hook - Part1 : Set === */
$extp = cot_getextensions('admin.ratings.loop');
/* ===== */
foreach ($sql->fetchAll() as $row)
{
	$id2 = $row['rating_code'];
	$sql1 = $db->query("SELECT COUNT(*) FROM $db_rated WHERE rated_code=" . $db->quote($id2));
	$votes = $sql1->fetchColumn();

	$rat_type = mb_substr($row['rating_code'], 0, 1);
	$rat_value = mb_substr($row['rating_code'], 1);

	switch($rat_type)
	{
		case 'p':
			$rat_url = cot_url('page', 'id='.$rat_value);
		break;
		default:
			$rat_url = '';
		break;
	}

	$t->assign(array(
		'ADMIN_RATINGS_ROW_URL_DEL' => cot_url('admin', 't=other&p=ratings&a=delete&id='.$row['rating_code'].'&d='.$durl.'&'.cot_xg()),
		'ADMIN_RATINGS_ROW_RATING_CODE' => $row['rating_code'],
		'ADMIN_RATINGS_ROW_RATING_AREA' => $row['rating_area'],
		'ADMIN_RATINGS_ROW_CREATIONDATE' => cot_date('datetime_medium', $row['rating_creationdate']),
		'ADMIN_RATINGS_ROW_CREATIONDATE_STAMP' => $row['rating_creationdate'],
		'ADMIN_RATINGS_ROW_VOTES' => $votes,
		'ADMIN_RATINGS_ROW_RATING_AVERAGE' => $row['rating_average'],
		'ADMIN_RATINGS_ROW_RAT_URL' => $rat_url,
		'ADMIN_RATINGS_ROW_ODDEVEN' => cot_build_oddeven($ii)
	));
	/* === Hook - Part2 : Include === */
	foreach ($extp as $ext)
	{
		include $ext;
	}
	/* ===== */
	$t->parse('MAIN.RATINGS_ROW');
	$ii++;
	$jj = $jj + $votes;
}

$t->assign(array(
	'ADMIN_RATINGS_URL_CONFIG' => cot_url('admin', 't=config&n=edit&o=extension&p=ratings'),
	'ADMIN_RATINGS_PAGINATION_PREV' => $pagenav['prev'],
	'ADMIN_RATINGS_PAGNAV' => $pagenav['main'],
	'ADMIN_RATINGS_PAGINATION_NEXT' => $pagenav['next'],
	'ADMIN_RATINGS_TOTALITEMS' => $totalitems,
	'ADMIN_RATINGS_ON_PAGE' => $ii,
	'ADMIN_RATINGS_TOTALVOTES' => $jj,
	'ADMIN_RATINGS_BREADCRUMBS' =>  cot_breadcrumbs($out['breadcrumbs'], false),	
));

cot_display_messages($t);

/* === Hook  === */
foreach (cot_getextensions('admin.ratings.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');

