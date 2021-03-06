<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * Tag search
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once $cfg['system_dir'] . '/header.php';

$a = cot_import('a', 'G', 'ALP');
$a = empty($a) ? 'all' : $a;
$qs = cot_import('t', 'G', 'TXT');
if(empty($qs)) $qs = cot_import('t', 'P', 'TXT');
$qs = str_replace('-', ' ', $qs);

$tl = cot_import('tl', 'G', 'BOL');
if ($tl && file_exists(cot_langfile('translit', 'system')))
{
	include_once cot_langfile('translit', 'system');
	$qs = strtr($qs, $cot_translitb);
}

list($pg, $d, $durl) = cot_import_pagenav('d',  $cfg['maxrowsperpage']);
$dt = (int)cot_import('dt', 'G', 'INT');
$perpage = $cfg['tags']['perpage'];

// Array to register areas with tag functions provided
$tag_areas = array();

if (cot_extension_active('page'))
{
	require_once cot_incfile('page', 'functions');
	$tag_areas[] = 'pages';
}

if (cot_extension_active('forums'))
{
	require_once cot_incfile('forums', 'functions');
	$tag_areas[] = 'forums';
}

// Sorting order
$o = cot_import('order', 'P', 'ALP');
if (empty($o))
{
	$o = mb_strtolower($cfg['tags']['sort']);
}
$tag_order = '';
$tag_orders = array('Title', 'Date', 'Category');
foreach ($tag_orders as $order)
{
	$ord = mb_strtolower($order);
	$selected = $ord == $o ? 'selected="selected"' : '';
	$tag_order .= cot_rc('input_option', array('value' => $ord, 'selected' => $selected, 'title' => $L[$order]));
}

/* == Hook for the extensions == */
foreach (cot_getextensions('tags.first') as $ext)
{
	include $ext;
}
/* ===== */

if ($cfg['tags']['noindex'])
{
	$out['head'] .= $R['code_noindex'];
}
$out['subtitle'] = empty($qs) ? $L['Tags'] : htmlspecialchars(strip_tags($qs)) . ' - ' . $L['tags_Search_results'];

$t->assign(array(
	'TAGS_ACTION' => cot_url('index', 'e=tags&a=' . $a),
	'TAGS_HINT' => $L['tags_Query_hint'],
	'TAGS_QUERY' => htmlspecialchars($qs),
	'TAGS_ORDER' => $tag_order
));

if ($a == 'pages' && cot_extension_active('page'))
{
	if(empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('pages');
	}
	else
	{
		// Search results
		cot_tag_search_pages($qs);
	}
}
elseif ($a == 'forums' && cot_extension_active('forums'))
{
	if (empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('forums');
	}
	else
	{
		// Search results
		cot_tag_search_forums($qs);
	}
}
elseif ($a == 'all')
{
	if (empty($qs))
	{
		// Form and cloud
		cot_tag_search_form('all');
	}
	else
	{
		// Search results
		foreach ($tag_areas as $area)
		{
			$tag_search_callback = 'cot_tag_search_' . $area;
			if (function_exists($tag_search_callback))
			{
				$tag_search_callback($qs);
			}
		}
	}
}
else
{
	/* == Hook for the extensions == */
	foreach (cot_getextensions('tags.search.custom') as $ext)
	{
		include $ext;
	}
	/* ===== */
}

/**
 * Search by tag in pages
 *
 * @param string $query User-entered query string
 * @global CotDB $db
 */
function cot_tag_search_pages($query)
{
	global $db, $t, $L, $lang, $cfg, $usr, $qs, $d, $db_tag_references, $db_pages, $o, $row, $sys;

	if (!cot_extension_active('page'))
	{
		return;
	}

	$query = cot_tag_parse_query($query, 'p.page_id');
	if (empty($query))
	{
		return;
	}

	$totalitems = $db->query("SELECT DISTINCT COUNT(*)
		FROM $db_tag_references AS r LEFT JOIN $db_pages AS p
			ON r.tag_item = p.page_id
		WHERE r.tag_area = 'pages' AND ($query) AND p.page_state = 0")->fetchColumn();
	switch($o)
	{
		case 'title':
			$order = 'ORDER BY `page_title`';
		break;
		case 'date':
			$order = 'ORDER BY `page_date` DESC';
		break;
		case 'category':
			$order = 'ORDER BY `page_cat`';
		break;
		default:
			$order = '';
	}


	/* == Hook == */
	foreach (cot_getextensions('tags.search.pages.query') as $ext)
	{
		include $ext;
	}
	/* ===== */

	$sql = $db->query("SELECT DISTINCT p.* $join_columns
		FROM $db_tag_references AS r LEFT JOIN $db_pages AS p
			ON r.tag_item = p.page_id $join_tables
		WHERE r.tag_area = 'pages' AND ($query) AND p.page_id IS NOT NULL AND p.page_state = 0 $join_where
		$order
		LIMIT $d, {$cfg['maxrowsperpage']}");
	$t->assign('TAGS_RESULT_TITLE', $L['tags_Found_in_pages']);
	$pcount = $sql->rowCount();

	/* == Hook : Part 1 == */
	$extp = cot_getextensions('tags.search.pages.loop');
	/* ===== */

	if ($pcount > 0)
	{
		foreach ($sql->fetchAll() as $row)
		{
			if(($row['page_begin'] > 0 && $row['page_begin'] > $sys['now']) || ($row['page_expire'] > 0 && $sys['now'] > $row['page_expire']))
			{
				--$pcount;
				continue;
			}

			$tags = cot_tag_list($row['page_id']);
			$tag_list = '';
			$tag_i = 0;
			foreach ($tags as $tag)
			{
				$tag_t = $cfg['tags']['title'] ? cot_tag_title($tag) : $tag;
				$tag_u = $cfg['tags']['translit'] ? cot_translit_encode($tag) : $tag;
				$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
				if ($tag_i > 0) $tag_list .= ', ';
				$tag_list .= cot_rc_link(cot_url('index', array('e' => 'tags', 'a' => 'pages', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)), htmlspecialchars($tag_t));
				$tag_i++;
			}

			$t->assign(cot_generate_pagetags($row, 'TAGS_RESULT_ROW_', $cfg['page']['cat___default']['truncatetext']));
			$t->assign(array(
				//'TAGS_RESULT_ROW_URL' => empty($row['page_alias']) ? cot_url('page', 'c='.$row['page_cat'].'&id='.$row['page_id']) : cot_url('page', 'c='.$row['page_cat'].'&al='.$row['page_alias']),
				'TAGS_RESULT_ROW_TITLE' => htmlspecialchars($row['page_title']),
				'TAGS_RESULT_ROW_PATH' => cot_breadcrumbs(cot_structure_buildpath('page', $row['page_cat']), false),
				'TAGS_RESULT_ROW_TAGS' => $tag_list
			));
			/* == Hook : Part 2 == */
			foreach ($extp as $ext)
			{
				include $ext;
			}
			/* ===== */
			$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_ROW');
		}
		$sql->closeCursor();
		$qs_u = $cfg['tags']['translit'] ? cot_translit_encode($qs) : $qs;
		$tl = $lang != 'en' && $qs_u != $qs ? 1 : null;
		$pagenav = cot_pagenav('index', array('e' => 'tags', 'a' => 'pages', 't' => $qs_u, 'tl' => $tl), $d, $totalitems, $cfg['maxrowsperpage']);
		$t->assign(array(
			'TAGS_PAGEPREV' => $pagenav['prev'],
			'TAGS_PAGENEXT' => $pagenav['next'],
			'TAGS_PAGNAV' => $pagenav['main']
		));

		/* == Hook == */
		foreach (cot_getextensions('tags.search.pages.tags') as $ext)
		{
			include $ext;
		}
		/* ===== */
	}

	if($pcount == 0)
	{
		$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_NONE');
	}

	$t->parse('MAIN.TAGS_RESULT');
}

/**
 * Search by tag in forums
 *
 * @param string $query User-entered query string
 * @global CotDB $db
 */
function cot_tag_search_forums($query)
{
	global $db, $t, $L, $lang, $cfg, $usr, $qs, $d, $db_tag_references, $db_forum_topics, $o, $row;

	if (!cot_extension_active('forums'))
	{
		return;
	}

	$query = cot_tag_parse_query($query, 't.ft_id');
	if (empty($query))
	{
		return;
	}

	$totalitems = $db->query("SELECT DISTINCT COUNT(*)
		FROM $db_tag_references AS r LEFT JOIN $db_forum_topics AS t
			ON r.tag_item = t.ft_id
		WHERE r.tag_area = 'forums' AND ($query)")->fetchColumn();
	switch($o)
	{
		case 'title':
			$order = 'ORDER BY `ft_title`';
		break;
		case 'date':
			$order = 'ORDER BY `ft_updated` DESC';
		break;
		case 'category':
			$order = 'ORDER BY `ft_cat`';
		break;
		default:
			$order = '';
	}
	$sql = $db->query("SELECT DISTINCT t.ft_id, t.ft_cat, t.ft_title
		FROM $db_tag_references AS r LEFT JOIN $db_forum_topics AS t
			ON r.tag_item = t.ft_id
		WHERE r.tag_area = 'forums' AND ($query) AND t.ft_id IS NOT NULL
		$order
		LIMIT $d, {$cfg['maxrowsperpage']}");
	$t->assign('TAGS_RESULT_TITLE', $L['tags_Found_in_forums']);
	if ($sql->rowCount() > 0)
	{
		while ($row = $sql->fetch())
		{
			$tags = cot_tag_list($row['ft_id'], 'forums');
			$tag_list = '';
			$tag_i = 0;
			foreach ($tags as $tag)
			{
				$tag_t = $cfg['tags']['title'] ? cot_tag_title($tag) : $tag;
				$tag_u = $cfg['tags']['translit'] ? cot_translit_encode($tag) : $tag;
				$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
				if ($tag_i > 0) $tag_list .= ', ';
				$tag_list .= cot_rc_link(cot_url('index', array('e' => 'tags', 'a' => 'forums', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)), htmlspecialchars($tag_t));
				$tag_i++;
			}
			$master = ($row['fs_masterid'] > 0) ? array($row['fs_masterid'], $row['fs_mastername']) : false;
			$t->assign(array(
				'TAGS_RESULT_ROW_URL' => cot_url('forums', 'm=posts&q='.$row['ft_id']),
				'TAGS_RESULT_ROW_TITLE' => htmlspecialchars($row['ft_title']),
				'TAGS_RESULT_ROW_PATH' => cot_breadcrumbs(cot_forums_buildpath($row['ft_cat']), false),
				'TAGS_RESULT_ROW_TAGS' => $tag_list
			));
			$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_ROW');
		}
		$sql->closeCursor();
		$qs_u = $cfg['tags']['translit'] ? cot_translit_encode($qs) : $qs;
		$tl = $lang != 'en' && $qs_u != $qs ? 1 : null;
		$pagenav = cot_pagenav('index', array('e' => 'tags', 'a' => 'forums', 't' => $qs_u, 'tl' => $tl), $d, $totalitems, $cfg['maxrowsperpage']);
		$t->assign(array(
			'TAGS_PAGEPREV' => $pagenav['prev'],
			'TAGS_PAGENEXT' => $pagenav['next'],
			'TAGS_PAGNAV' => $pagenav['main']
		));
	}
	else
	{
		$t->parse('MAIN.TAGS_RESULT.TAGS_RESULT_NONE');
	}
	$t->parse('MAIN.TAGS_RESULT');
}

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';