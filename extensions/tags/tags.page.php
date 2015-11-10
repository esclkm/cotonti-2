<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Tags=page.tpl:{PAGE_TAGS_ROW_TAG},{PAGE_TAGS_ROW_URL}
[END_COT_EXT]
==================== */

/**
 * Renders page tags output
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['pages'])
{
	if (!isset($tags))
	{
		require_once cot_incfile('tags', 'functions');
		if (cot_extension_active('i18n') && $i18n_enabled && $i18n_notmain)
		{
			$tags_extra = array('tag_locale' => $i18n_locale);
		}
		else
		{
			$tags_extra = null;
		}
		$item_id = $pag['page_id'];
		$tags = cot_tag_list($item_id, 'pages', $tags_extra);
	}
	if (count($tags) > 0)
	{
		$tag_i = 0;
		foreach ($tags as $tag)
		{
			$tag_u = $cfg['tags']['translit'] ? cot_translit_encode($tag) : $tag;
			$tl = $lang != 'en' && $tag_u != $tag ? 1 : null;
			$t->assign(array(
				'PAGE_TAGS_ROW_TAG' => $cfg['tags']['title'] ? htmlspecialchars(cot_tag_title($tag)) : htmlspecialchars($tag),
				'PAGE_TAGS_ROW_URL' => cot_url('index', array('e' => 'tags', 'a' => 'pages', 't' => str_replace(' ', '-', $tag_u), 'tl' => $tl))
			));
			$t->parse('MAIN.PAGE_TAGS_ROW');
			$tag_i++;
		}
	}
	else
	{
		$t->assign(array(
			'PAGE_NO_TAGS' => $L['tags_Tag_cloud_none']
		));
		$t->parse('MAIN.PAGE_NO_TAGS');
	}
}
