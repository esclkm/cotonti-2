<?php

/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Recent pages, topics in forums, users, comments
 *
 * @package recentitems
 * @version 0.7.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2014
 * @license BSD
 */
defined('COT_CODE') or die("Wrong URL.");

require_once $cfg['system_dir'] . '/header.php';

$days = cot_import('days', 'G', 'INT');
list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['recentitems']['itemsperpage']);
$mode = cot_import('mode', 'G', 'TXT');

if ($days == 0)
{
	if ($usr['id'] > 0)
	{
		$timeback = $usr['lastvisit'];
	}
	else
	{
		$days = 1;
	}
}
if ($days > 0)
{
	$timeminus = $days * 86400;
	$timeback = $sys['now'] - $timeminus;
}

require_once cot_incfile('recentitems', 'module');
$totalrecent[] = 0;
if ($cfg['recentitems']['newpages'] && cot_extension_active('page') && (empty($mode) || $mode == 'pages'))
{
	require_once cot_incfile('page', 'module');
	$res = cot_build_recentpages('recentitems.pages', $timeback, $cfg['recentitems']['itemsperpage'], $d, $pagetitlelimit, $cfg['recentitems']['newpagestext'], $cfg['recentitems']['rightscan']);
	$t->assign('RECENT_PAGES', $res);
}

if ($cfg['recentitems']['newforums'] && cot_extension_active('forums') && (empty($mode) || $mode == 'forums'))
{
	require_once cot_incfile('forums', 'module');
	$res = cot_build_recentforums('recentitems.forums', $timeback, $cfg['recentitems']['itemsperpage'], $d, $forumtitlelimit, $cfg['recentitems']['rightscan']);
	$t->assign('RECENT_FORUMS', $res);
}

if ($mode != 'pages' || $mode != 'forums')
{
	/* === Hook === */
	foreach (cot_getextensions('recentitems.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

$out['subtitle'] = $L['recentitems_title'];

$totalpages = max($totalrecent);
$days = ($days > 0) ? "&days=" . $days : "";
$mode = (!empty($mode)) ? "&mode=" . $mode : "";
$pagenav = cot_pagenav('module', 'e=recentitems' . $days . $mode, $d, $totalpages, $cfg['recentitems']['itemsperpage']);

$t->assign(array(
	'PAGE_PAGENAV' => $pagenav['main'],
	'PAGE_PAGEPREV' => $pagenav['prev'],
	'PAGE_PAGENEXT' => $pagenav['next']
));
$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';