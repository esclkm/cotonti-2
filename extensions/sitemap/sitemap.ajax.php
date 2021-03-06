<?php
/* ====================
 * [BEGIN_COT_EXT]
 * Hooks=ajax
 * [END_COT_EXT]
==================== */

/**
 * XML sitemap generator
 *
 * @package sitemap
 * @author Feliz Team
 * @copyright Copyright (c) 2012-2014, Feliz Team
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('sitemap', 'functions');

header('Content-Type: application/xml; charset=utf-8');

// Large sitemaps are split into pages
$d = cot_import('d', 'G', 'ALP');
$perpage = (int) $cfg['sitemap']['perpage'];

$count_file = $cfg['cache_dir'] . '/sitemap/sitemap.count';
if (file_exists($count_file) && filesize($count_file) > 0
	&& ($sys['now'] - filemtime($count_file) < $cfg['sitemap']['cache_ttl']))
{
	// Cache is valid
	$regenerate = false;
	$items = (int) file_get_contents($count_file);
}
else
{
	// Cache is invalid
	$regenerate = true;
}

if ($regenerate)
{
	// Regenerate the sitemap
	$t = new XTemplate(cot_tplfile('sitemap'));
	$items = 0;

	// Start the sitemap with index
	sitemap_parse($t, $items, array(
		'url'  => '', // root
		'date' => '', // omit
		'freq' => $cfg['sitemap']['index_freq'],
		'prio' => $cfg['sitemap']['index_prio']
	));

	if ($cfg['sitemap']['page'] && cot_extension_active('page'))
	{
		// Sitemap for page extension
		require_once cot_incfile('page', 'functions');

		// Page categories
		$auth_cache = array();

		$category_list = $structure['page'];

		/* === Hook === */
		foreach (cot_getextensions('sitemap.page.categorylist') as $ext)
		{
			include $ext;
		}
		/* ===== */

		foreach ($category_list as $c => $cat)
		{
			$auth_cache[$c] = cot_auth('page', $c, 'R');
			if (!$auth_cache[$c] || $c === 'system') continue;
			// Pagination support
			$maxrowsperpage = ($cfg['page']['cat_' . $c]['maxrowsperpage']) ? $cfg['page']['cat_' . $c]['maxrowsperpage'] : $cfg['page']['cat___default']['maxrowsperpage'];
			$subs = floor($cat['count'] / $maxrowsperpage) + 1;
			foreach (range(1, $subs) as $pg)
			{
				$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
				$urlp = $pg > 1 ? "c=$c&d=$d" : "c=$c";
				sitemap_parse($t, $items, array(
					'url'  => cot_url('page', $urlp),
					'date' => '', // omit
					'freq' => $cfg['sitemap']['page_freq'],
					'prio' => $cfg['sitemap']['page_prio']
				));
			}
		}

		// Pages
		$sitemap_join_columns = '';
		$sitemap_join_tables = '';
		$sitemap_where = array();
		$sitemap_where['state'] = 'page_state = 0';
		$sitemap_where['date'] = "page_begin <= {$sys['now']} AND (page_expire = 0 OR page_expire > {$sys['now']})";

		/* === Hook === */
		foreach (cot_getextensions('sitemap.page.query') as $ext)
		{
			include $ext;
		}
		/* ===== */

		$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
		$res = $db->query("SELECT p.page_id, p.page_alias, p.page_cat, p.page_updated $sitemap_join_columns
			FROM $db_pages AS p $sitemap_join_tables
			$sitemap_where
			ORDER BY p.page_cat, p.page_id");
		foreach ($res->fetchAll() as $row)
		{
			if (!$auth_cache[$row['page_cat']]) continue;
			$urlp = array('c' => $row['page_cat']);
			empty($row['page_alias']) ? $urlp['id'] = $row['page_id'] : $urlp['al'] = $row['page_alias'];
			sitemap_parse($t, $items, array(
				'url'  => cot_url('page', $urlp),
				'date' => $row['page_updated'],
				'freq' => $cfg['sitemap']['page_freq'],
				'prio' => $cfg['sitemap']['page_prio']
			));
		}
	}

	if ($cfg['sitemap']['forums'] && cot_extension_active('forums'))
	{
		// Sitemap for forums extension
		require_once cot_incfile('forums', 'functions');

		// Get forum stats
		$cat_top = array();
		$res = $db->query("SELECT * FROM $db_forum_stats ORDER by fs_cat DESC");
		foreach ($res->fetchAll() as $row)
		{
			$cat_top[$row['fs_cat']] = $row;
		}

		// Forums categories
		$auth_cache = array();
		$maxrowsperpage = $cfg['forums']['maxtopicsperpage'];

		$category_list = $structure['forums'];

		/* === Hook === */
		foreach (cot_getextensions('sitemap.forums.categorylist') as $ext)
		{
			include $ext;
		}
		/* ===== */

		foreach ($category_list as $c => $cat)
		{
			$auth_cache[$c] = cot_auth('forums', $c, 'R');
			if (!$auth_cache[$c] || substr_count($cat['path'], '.') == 0) continue;
			// Pagination support
			$count = $cat_top[$c]['fs_topiccount'];
			$subs = floor($count / $maxrowsperpage) + 1;
			// Pages starting from second
			foreach (range(1, $subs) as $pg)
			{
				$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
				$urlp = $pg > 1 ? "m=topics&s=$c&d=$d" : "m=topics&s=$c";
				sitemap_parse($t, $items, array(
					'url'  => cot_url('forums', $urlp),
					'date' => $cat_top[$c]['fs_lt_date'],
					'freq' => $cfg['sitemap']['forums_freq'],
					'prio' => $cfg['sitemap']['forums_prio']
				));
			}
		}

		// Topics
		$sitemap_join_columns = '';
		$sitemap_join_tables = '';
		$sitemap_where = array();

		/* === Hook === */
		foreach (cot_getextensions('sitemap.forums.query') as $ext)
		{
			include $ext;
		}
		/* ===== */

		$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
		$res = $db->query("SELECT t.ft_id, t.ft_cat, t.ft_updated, t.ft_postcount $sitemap_join_columns
			FROM $db_forum_topics t $sitemap_join_tables
				LEFT JOIN $db_structure s ON (s.structure_area = 'forums' AND t.ft_cat = s.structure_code)
			$sitemap_where
			ORDER BY t.ft_cat");
		$maxrowsperpage = $cfg['forums']['maxpostsperpage'];
		foreach ($res->fetchAll() as $row)
		{
			if (!$auth_cache[$row['ft_cat']]) continue;
			$q = $row['ft_id'];
			// Pagination support
			$count = $row['ft_postcount'];
			$subs = floor($count / $maxrowsperpage) + 1;
			// Pages starting from second
			foreach (range(1, $subs) as $pg)
			{
				$d = $cfg['easypagenav'] ? $pg : ($pg - 1) * $maxrowsperpage;
				$urlp = $pg > 1 ? "m=posts&q=$q&d=$d" : "m=posts&q=$q";
				sitemap_parse($t, $items, array(
					'url'  => cot_url('forums', $urlp),
					'date' => $row['ft_updated'],
					'freq' => $cfg['sitemap']['forums_freq'],
					'prio' => $cfg['sitemap']['forums_prio']
				));
			}
		}

		unset($cat_top);
	}

	if ($cfg['sitemap']['users'] && cot_extension_active('users') && cot_auth('users', 'a', 'R'))
	{
		// Sitemap for users extension
		require_once cot_incfile('users', 'functions');

		// User profiles
		$sitemap_join_columns = '';
		$sitemap_join_tables = '';
		$sitemap_where = array();

		/* === Hook === */
		foreach (cot_getextensions('sitemap.users.query') as $ext)
		{
			include $ext;
		}
		/* ===== */

		$sitemap_where = count($sitemap_where) > 0 ? 'WHERE ' . join(' AND ', $sitemap_where) : '';
		$res = $db->query("SELECT u.user_id, u.user_name $sitemap_join_columns
			FROM $db_users AS u $sitemap_join_tables
			$sitemap_where
			ORDER BY user_id");
		foreach ($res->fetchAll() as $row)
		{
			sitemap_parse($t, $items, array(
				'url'  => cot_url('users', array('m' => 'details', 'id' => $row['user_id'], 'u' => $row['user_name'])),
				'date' => '', // omit
				'freq' => $cfg['sitemap']['users_freq'],
				'prio' => $cfg['sitemap']['users_prio']
			));
		}
	}

	/* === Hook === */
	foreach (cot_getextensions('sitemap.main') as $ext)
	{
		include $ext;
	}
	/* ===== */

	// Save the last page
	$t->parse();
	sitemap_save($t->text(), (int) ceil($items / $perpage) - 1);
	// Save count file
	file_put_contents($count_file, $items);
}

if ($a == 'index')
{
	// Show sitemap index
	$t = new XTemplate(cot_tplfile('sitemap.index'));
	$pages = (int) ceil($items / $perpage);
	foreach (range(0, $pages - 1) as $pg)
	{
		$durl = $pg > 0 ? "&d=$pg" : '';
		$filename = $pg > 0 ? $cfg['cache_dir'] . "/sitemap/sitemap.$pg.xml" : $cfg['cache_dir'] . "/sitemap/sitemap.xml";
		$t->assign(array(
			'SITEMAP_ROW_URL' => COT_ABSOLUTE_URL . cot_url('index', 'r=sitemap'.$durl),
			'SITEMAP_ROW_DATE' => sitemap_date(filemtime($filename))
		));
		$t->parse('MAIN.SITEMAP_ROW');
	}
	$t->parse();
	echo sitemap_compress($t->text());

}
else
{
	// Show requested sitemap
	sitemap_load($items, $d);
}

exit;
