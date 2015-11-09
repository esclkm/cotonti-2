<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin
[END_COT_EXT]
==================== */

/**
 * Statistics for the forums
 *
 * @package forumstats
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('forums', 'any');
cot_block($usr['isadmin']);

$t = new XTemplate(cot_tplfile('forums.admin'));

require_once cot_incfile('forums', 'functions');

$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions'), $L['Extensions']);
$out['breadcrumbs'][] = array(cot_url('admin', 't=extensions&a=details&mod='.$m), $cot_extensions[$m]['title']);
$out['breadcrumbs'][] = array(cot_url('admin', 't='.$m), $L['Administration']);

$adminsubtitle = $L['Forums'];

/* === Hook  === */
foreach (cot_getextensions('forums.admin.first') as $ext)
{
	include $ext;
}
/* ===== */


$sql_forums = $db->query("SELECT * FROM $db_forum_topics WHERE 1 ORDER BY ft_creationdate DESC LIMIT 10");
$ii = 0;

while ($row = $sql_forums->fetch())
{
	$ii++;
	$t->assign(array(
		'ADMIN_FORUMS_ROW_II' => $ii,
		'ADMIN_FORUMS_ROW_FORUMS' => cot_breadcrumbs(cot_forums_buildpath($row['ft_cat']), false),
		'ADMIN_FORUMS_ROW_URL' => cot_url('forums', 'm=posts&q='.$row['ft_id']),
		'ADMIN_FORUMS_ROW_TITLE' => htmlspecialchars($row['ft_title']),
		'ADMIN_FORUMS_ROW_POSTCOUNT' => $row['ft_postcount']
	));
	$t->parse('MAIN.ADMIN_FORUMS_ROW_USER');
}
$sql_forums->closeCursor();

$t->assign(array(
	'ADMIN_FORUMS_URL_CONFIG' => cot_url('admin', 't=config&n=edit&o=extension&p=forums'),
	'ADMIN_FORUMS_URL_STRUCTURE' => cot_url('admin', 't=structure&n=forums'),
	'ADMIN_FORUMS_TOTALTOPICS' => $db->countRows($db_forum_topics),
	'ADMIN_FORUMS_TOTALPOSTS' => $db->countRows($db_forum_posts),
	'ADMIN_FORUMS_TOTALVIEWS' => $db->query("SELECT SUM(fs_viewcount) FROM $db_forum_stats")->fetchColumn(),
	'ADMIN_FORUMS_BREADCRUMBS' => cot_breadcrumbs($out['breadcrumbs'], false),		
));

/* === Hook  === */
foreach (cot_getextensions('forums.admin.tags') as $ext)
{
	include $ext;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text('MAIN');
