<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.sections.tags
Tags=forums.sections.tpl:{FORUMS_SECTIONS_TAG_CLOUD},{FORUMS_SECTIONS_TAG_CLOUD_ALL_LINK}
[END_COT_EXT]
==================== */

/**
 * Forum tag cloud
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['forums'])
{
	require_once cot_incfile('tags', 'functions');
	// Get all subcategories
	$limit = $cfg['tags']['lim_forums'] == 0 ? null : (int) $cfg['tags']['lim_forums'];
	$tcloud = cot_tag_cloud('forums', $cfg['tags']['order'], $limit);
	$tc_html = $R['tags_code_cloud_open'];
	$tag_count = 0;
	foreach ($tcloud as $tag => $cnt)
	{
		$tag_count++;
		$tag_t = $cfg['tags']['title'] ? cot_tag_title($tag) : $tag;
		$tag_u = $cfg['tags']['translit'] ? cot_translit_encode($tag) : $tag;
		$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
		foreach ($tc_styles as $key => $val)
		{
			if ($cnt <= $key)
			{
				$dim = $val;
				break;
			}
		}
		$tc_html .= cot_rc('tags_link_cloud_tag', array(
			'url' => cot_url('index', array('e' => 'tags', 'a' => 'forums', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)),
			'tag_title' => htmlspecialchars($tag_t),
			'dim' => $dim
		));
	}
	$tc_html .= $R['tags_code_cloud_close'];
	$tc_html = ($tag_count > 0) ? $tc_html : $L['tags_Tag_cloud_none'];
	$t->assign('FORUMS_SECTIONS_TAG_CLOUD', $tc_html);
	if ($cfg['tags']['more'] && $limit > 0 && $tag_count == $limit)
	{
		$t->assign('FORUMS_SECTIONS_TAG_CLOUD_ALL_LINK',
			cot_rc('tags_code_cloud_more', array('url' => cot_url('index', 'e=tags&a=forums'))));
	}
}
