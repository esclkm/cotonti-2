<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.edit.update.done,i18n.page.edit.update
[END_COT_EXT]
==================== */

/**
 * Updates page tags
 *
 * @package tags
 * @version 0.7.0
 * @author Feliz Team
 * @copyright Copyright (c) Feliz Team 2008-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if ($cfg['tags']['pages'] && cot_auth('tags', 'any', 'W'))
{
	require_once cot_incfile('tags', 'functions');
	// I18n
	if (cot_get_caller() == 'i18n.page')
	{
		global $i18n_locale;
		$tags_extra = array('tag_locale' => $i18n_locale);
	}
	else
	{
		$tags_extra = null;
	}
	$rtags = cot_import('rtags', 'P', 'TXT');
	$tags = cot_tag_parse($rtags);
	$old_tags = cot_tag_list($id, 'pages', $tags_extra);
	$kept_tags = array();
	$new_tags = array();
	// Find new tags, count old tags that have been left
	$cnt = 0;
	foreach ($tags as $tag)
	{
		$p = array_search($tag, $old_tags);
		if($p !== false)
		{
			$kept_tags[] = $old_tags[$p];
			$cnt++;
		}
		else
		{
			$new_tags[] = $tag;
		}
	}
	// Remove old tags that have been removed
	$rem_tags = array_diff($old_tags, $kept_tags);
	foreach ($rem_tags as $tag)
	{
		cot_tag_remove($tag, $id, 'pages', $tags_extra);
	}
	// Add new tags
	$ncnt = count($new_tags);
	if ($cfg['tags']['limit'] > 0
		&& $ncnt > $cfg['tags']['limit'] - $cnt)
	{
		$lim = $cfg['tags']['limit'] - $cnt;
	}
	else
	{
		$lim = $ncnt;
	}
	for ($i = 0; $i < $lim; $i++)
	{
		cot_tag($new_tags[$i], $id, 'pages', $tags_extra);
	}
}
