<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=forums.posts.tags
Tags=forums.posts.tpl:{FORUMS_POSTS_TAGS}
[END_COT_EXT]
==================== */

/**
 * Forum post tags output
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
	if (!isset($tags))
	{
		require_once cot_incfile('tags', 'functions');
		$tags = cot_tag_list($q, 'forums');
	}
	if (count($tags) > 0)
	{
		$tc_html = $L['Tags'] . ': ';
		$tag_i = 0;
		foreach ($tags as $tag)
		{
			$tag_t = $cfg['tags']['title'] ? htmlspecialchars(cot_tag_title($tag)) : htmlspecialchars($tag);
			$tag_u = $cfg['tags']['translit'] ? cot_translit_encode($tag) : $tag;
			$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
			if ($tag_i > 0) $tc_html .= ', ';
			$tc_html .= cot_rc('tags_link_tag', array(
				'url' => cot_url('index', array('e' => 'tags', 'a' => 'forums', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl)),
				'tag_title' => $tag_t
			));
			$tag_i++;
		}
		$t->assign('FORUMS_POSTS_TAGS', $tc_html);
	}
	else
	{
		//$tc_html = $L['tags_Tag_cloud_none'];
		$t->assign('FORUMS_POSTS_TAGS', '');
	}
}
